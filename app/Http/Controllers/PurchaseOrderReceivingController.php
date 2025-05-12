<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderReceiving;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderReceivingController extends Controller
{
    /**
     * Display a listing of all receivings.
     */
    public function index()
    {
        $receivings = PurchaseOrderReceiving::with([
                'orderDetail.product', 
                'orderDetail.purchaseOrder.supplier'
            ])
            ->latest()
            ->paginate(10);
            
        return view('receivings.index', compact('receivings'));
    }

    /**
     * Show the form for creating a new receiving entry for a specific order detail.
     */
    public function create(OrderDetail $orderDetail)
    {
        $purchaseOrder = $orderDetail->purchaseOrder;
        
        if ($purchaseOrder->status !== 'approved') {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->withErrors(['error' => 'Only approved purchase orders can receive items.']);
        }

        return view('receivings.create', compact('orderDetail', 'purchaseOrder'));
    }

    /**
     * Store a newly created receiving entry in storage.
     */
    public function store(Request $request, OrderDetail $orderDetail)
    {
        $request->validate([
            'quantity_received' => 'required|integer|min:1',
            'received_by' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $purchaseOrder = $orderDetail->purchaseOrder;
        
        if ($purchaseOrder->status !== 'approved') {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->withErrors(['error' => 'Only approved purchase orders can receive items.']);
        }

        try {
            DB::beginTransaction();

            // Create receiving record
            $receiving = $orderDetail->receivings()->create([
                'received_date' => now(),
                'quantity_received' => $request->quantity_received,
                'received_by' => $request->received_by,
                'notes' => $request->notes,
            ]);

            // Update inventory quantity
            $part = $orderDetail->part;
            $part->quantity += $request->quantity_received;
            $part->save();

            // Log the inventory change
            InventoryLog::create([
                'product_id' => $part->id,
                'type' => 'stock_in',
                'quantity' => $request->quantity_received,
                'reference' => $purchaseOrder->id,
                'remarks' => 'Stock received from purchase order',
            ]);

            // Check if fully received
            $totalReceived = $orderDetail->receivings()->sum('quantity_received');
            
            // Check if all items in this purchase order are fully received
            $allReceived = true;
            foreach ($purchaseOrder->orderDetails as $detail) {
                $detailTotalReceived = $detail->receivings()->sum('quantity_received');
                if ($detailTotalReceived < $detail->quantity_ordered) {
                    $allReceived = false;
                    break;
                }
            }

            // If all items are fully received, update the purchase order status
            if ($allReceived) {
                $purchaseOrder->update(['status' => 'received']);
            }

            DB::commit();

            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Items received successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to process receiving. ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified receiving.
     */
    public function show(PurchaseOrderReceiving $receiving)
    {
        $receiving->load(['orderDetail.part', 'orderDetail.purchaseOrder.supplier']);
        return view('receivings.show', compact('receiving'));
    }

    /**
     * Remove the specified receiving from storage.
     * Note: This should only be allowed for admins and with caution.
     */
    public function destroy(PurchaseOrderReceiving $receiving)
    {
        // This should include logic to check permissions and adjust inventory accordingly
        try {
            DB::beginTransaction();

            $orderDetail = $receiving->orderDetail;
            $purchaseOrder = $orderDetail->purchaseOrder;
            
            // Revert inventory quantity
            $part = $orderDetail->part;
            $part->quantity -= $receiving->quantity_received;
            $part->save();
            
            // Delete the receiving
            $receiving->delete();
            
            // Update purchase order status if needed
            if ($purchaseOrder->status === 'received') {
                $purchaseOrder->update(['status' => 'approved']);
            }

            DB::commit();

            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Receiving record deleted successfully and inventory adjusted.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete receiving. ' . $e->getMessage()]);
        }
    }

    /**
     * Show all purchase orders for Stock In panel with filter/search.
     */
    public function stockInList(Request $request)
    {
        $query = \App\Models\PurchaseOrder::with(['supplier', 'orderDetails.product'])
            ->whereIn('status', ['pending', 'approved', 'partial']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('id', $search)
                  ->orWhereHas('supplier', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%");
                  })
                  ->orWhereHas('orderDetails.product', function($q2) use ($search) {
                      $q2->where('description', 'like', "%$search%")
                         ->orWhere('type', 'like', "%$search%")
                         ->orWhere('name', 'like', "%$search%")
                         ->orWhere('serial_number', 'like', "%$search%")
                         ;
                  });
            });
        }

        $purchaseOrders = $query->latest()->paginate(10);
        return view('receivings.stock-in', compact('purchaseOrders'));
    }

    /**
     * Show the form to receive items for a purchase order.
     */
    public function showReceiveForm(PurchaseOrder $purchaseOrder)
    {
        if (!in_array($purchaseOrder->status, ['approved', 'partial'])) {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->withErrors(['error' => 'Only approved or partially received purchase orders can receive items.']);
        }

        $purchaseOrder->load(['supplier', 'orderDetails.product', 'orderDetails.receivings']);
        return view('receivings.receive', compact('purchaseOrder'));
    }

    /**
     * Process the receiving of items for a purchase order.
     */
    public function processReceive(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'receivings' => 'required|array',
            'receivings.*.order_detail_id' => 'required|exists:order_details,id',
            'receivings.*.quantity_received' => 'required|integer|min:1',
            'receivings.*.notes' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $allReceived = true;
            $anyReceived = false;

            foreach ($request->receivings as $receiving) {
                if ($receiving['quantity_received'] > 0) {
                    $orderDetail = OrderDetail::findOrFail($receiving['order_detail_id']);

                    // Create receiving record
                    $orderDetail->receivings()->create([
                        'received_date' => now(),
                        'quantity_received' => $receiving['quantity_received'],
                        'received_by' => auth()->user()->name, // Automatically set to the logged-in user's name
                        'notes' => $receiving['notes'] ?? null,
                    ]);

                    // Update inventory quantity
                    $product = $orderDetail->product;
                    $product->quantity += $receiving['quantity_received'];
                    $product->save();

                    // Log the stock-in action
                    InventoryLog::create([
                        'product_id' => $product->id,
                        'type' => 'stock_in',
                        'quantity' => $receiving['quantity_received'],
                        'reference' => $orderDetail->purchase_order_id,
                        'remarks' => 'Stock received from purchase order',
                    ]);
                }
            }

            // Check if all items are fully received
            foreach ($purchaseOrder->orderDetails as $detail) {
                $totalReceivedForDetail = $detail->receivings->sum('quantity_received');
                if ($totalReceivedForDetail < $detail->quantity_ordered) {
                    $allReceived = false;
                }
                if ($totalReceivedForDetail > 0) {
                    $anyReceived = true;
                }
            }

            // Update the purchase order status
            if ($allReceived) {
                $purchaseOrder->update(['status' => 'received']);
            } elseif ($anyReceived) {
                $purchaseOrder->update(['status' => 'partial']);
            }

            DB::commit();

            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Items received successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to process receiving. ' . $e->getMessage()]);
        }
    }
}