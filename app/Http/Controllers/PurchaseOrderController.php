<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the purchase orders.
     */
    public function index(Request $request)
    {
        $query = PurchaseOrder::query();

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $purchaseOrders = $query->with('supplier')->orderBy('created_at', 'desc')->paginate(10);
        $draftCount = PurchaseOrder::where('status', 'draft')->count();

        return view('purchase-orders.index', compact('purchaseOrders', 'draftCount'));
    }

    /**
     * Show the form for creating a new purchase order.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchase-orders.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created purchase order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Calculate total amount based on products and their prices
            $totalAmount = 0;
            foreach ($request->products as $product) {
                $productModel = Product::find($product['id']);
                $totalAmount += $product['quantity'] * $productModel->price_per_item;
            }

            // Create purchase order
            $purchaseOrder = PurchaseOrder::create([
                'supplier_id' => $request->supplier_id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // Create order details
            foreach ($request->products as $product) {
                $productModel = Product::find($product['id']);
                OrderDetail::create([
                    'product_id' => $product['id'],
                    'purchase_order_id' => $purchaseOrder->id,
                    'quantity_ordered' => $product['quantity'],
                    'price_per_item' => $productModel->price_per_item,
                    'order_date' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('purchase-orders.index')
                ->with('success', 'Purchase order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create purchase order. ' . $e->getMessage()]);
        }
    }

    /**
     * Edit a purchase order.
     */
    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $suppliers = Supplier::all();

        return view('purchase-orders.edit', compact('purchaseOrder', 'suppliers'));
    }

    /**
     * Display the specified purchase order.
     */
    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with(['products', 'supplier'])->findOrFail($id);
        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Update the status of a purchase order.
     */
    public function updateStatus(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        if ($purchaseOrder->status == 'pending') {
            $purchaseOrder->update(['status' => $request->status]);

            return redirect()->back()->with('success', 'Purchase order approved successfully.');
        }

        return redirect()->back()->with('error', 'Invalid status update.');
    }

    /**
     * Remove the specified purchase order from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        // Only allow deletion of pending purchase orders
        if ($purchaseOrder->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending purchase orders can be deleted.']);
        }

        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    /**
     * Update the specified purchase order in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:draft,pending,completed,cancelled',
            'order_details.*.quantity_ordered' => 'nullable|integer|min:1', // Validate order details if provided
        ]);

        DB::beginTransaction();

        try {
            // Update the purchase order
            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'status' => $validated['status'],
            ]);

            // If the status is 'draft', update the order details
            if ($purchaseOrder->status == 'draft' && isset($validated['order_details'])) {
                foreach ($validated['order_details'] as $detailId => $detailData) {
                    $orderDetail = $purchaseOrder->orderDetails()->find($detailId);
                    if ($orderDetail) {
                        $orderDetail->update([
                            'quantity_ordered' => $detailData['quantity_ordered'],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('purchase-orders.index')
                ->with('success', 'Purchase order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update purchase order: ' . $e->getMessage()]);
        }
    }
}