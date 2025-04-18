<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('supplier')->orderBy('created_at', 'DESC')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('products.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'serial_number' => 'nullable|string|max:255|unique:products',
            'specifications' => 'nullable|string',
            'status' => 'required|in:available,assigned,maintenance,retired'
        ]);

        Product::create($validated);

        return redirect()->route('products')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('supplier')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'serial_number' => 'nullable|string|max:255|unique:products,serial_number,' . $id,
            'specifications' => 'nullable|string',
            'status' => 'required|in:available,assigned,maintenance,retired'
        ]);

        $product->update($validated);

        return redirect()->route('products')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products')->with('success', 'Product deleted successfully');
    }

    /**
     * Display low stock products.
     */
    public function lowStock()
    {
        $products = Product::whereRaw('quantity <= min_stock_level')->get();
        return view('products.low_stock', compact('products'));
    }
}