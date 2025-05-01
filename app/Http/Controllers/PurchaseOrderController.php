<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\PurchaseOrder;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')->get(); // Fetch purchase orders with supplier data
        $suppliers = Supplier::all(); // Fetch all suppliers
        $products = Product::all(); // Fetch all products
        return view('purchase_orders.index', compact('purchaseOrders', 'suppliers', 'products')); // Pass $products to the view
    }

    public function create()
    {
        $suppliers = Supplier::all(); // Fetch all suppliers for the dropdown
        return view('purchase_orders.create', compact('suppliers')); // Return the create view
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        // Deduct the purchased quantity from the product's stock
        $product = Product::where('name', $validatedData['product_name'])->first();
        if ($product) {
            if ($product->quantity < $validatedData['quantity']) {
                return redirect()->back()->withErrors(['quantity' => 'Not enough stock available for this product.']);
            }
            $product->decrement('quantity', $validatedData['quantity']);
        }

        // Create the purchase order
        PurchaseOrder::create([
            'product_name' => $validatedData['product_name'],
            'quantity' => $validatedData['quantity'],
            'supplier_id' => $validatedData['supplier_id'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order created successfully!');
    }

    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id); // Find the purchase order by ID
        $suppliers = Supplier::all(); // Fetch all suppliers for the dropdown
        return view('purchase_orders.edit', compact('purchaseOrder', 'suppliers')); // Pass data to the view
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled', // Validate against valid enum values
        ]);

        $purchaseOrder = PurchaseOrder::findOrFail($id); // Find the purchase order by ID
        $purchaseOrder->update($validatedData); // Update the purchase order with validated data

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order updated successfully!');
    }

    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id); // Find the purchase order by ID
        $purchaseOrder->delete(); // Delete the purchase order

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order deleted successfully!');
    }
}
