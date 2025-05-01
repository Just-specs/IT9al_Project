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
        return view('purchase_orders.index', compact('purchaseOrders', 'suppliers')); // Pass $suppliers to the view
    }

    public function create()
    {
        $suppliers = Supplier::all(); // Fetch all suppliers for the dropdown
        return view('purchase_orders.create', compact('suppliers')); // Return the create view
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled', // Validate against valid enum values
        ]);

        PurchaseOrder::create([
            'supplier_id' => $validatedData['supplier_id'],
            'total_amount' => 0, // Default value
            'status' => $validatedData['status'], // Ensure status is properly quoted
        ]);

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order created successfully!');
    }
}
