<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock; // Ensure the Stock model is imported
use App\Models\Supplier;
use App\Models\Product;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all(); // Fetch all stock records
        $suppliers = Supplier::all(); // Fetch all suppliers
        return view('stock.index', compact('stocks', 'suppliers')); // Pass $stocks and $suppliers to the view
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price_per_product' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
        ]);

        // Add the stock entry
        Stock::create([
            'product_name' => $validatedData['product_name'],
            'quantity' => $validatedData['quantity'],
            'price_per_product' => $validatedData['price_per_product'],
            'supplier' => $validatedData['supplier'],
        ]);

        // Check if the product already exists in the products table
        $product = Product::where('name', $validatedData['product_name'])->first();

        if ($product) {
            // Update the existing product's quantity and price
            $product->increment('quantity', $validatedData['quantity']);
            $product->price_per_item = $validatedData['price_per_product'];
            $product->save();
        } else {
            // Create a new product entry
            Product::create([
                'name' => $validatedData['product_name'],
                'type' => 'Unknown', // Default type, can be updated later
                'quantity' => $validatedData['quantity'],
                'price_per_item' => $validatedData['price_per_product'],
                'supplier_id' => Supplier::where('name', $validatedData['supplier'])->first()->id ?? null,
            ]);
        }

        return redirect()->route('stock.index')->with('success', 'Stock added successfully and reflected in products!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'supplier' => 'required|string|max:255',
        ]);

        $stock = Stock::findOrFail($id); // Find the stock by ID
        $stock->update($request->all()); // Update the stock record

        // Update the corresponding product
        $product = Product::where('name', $stock->product_name)->first();
        if ($product) {
            $product->update([
                'name' => $request->product_name,
                'quantity' => $request->quantity,
                'supplier_id' => Supplier::where('name', $request->supplier)->first()->id ?? null,
            ]);
        }

        return redirect()->route('stock.index')->with('success', 'Stock and corresponding product updated successfully!');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id); // Find the stock by ID

        // Update or remove the corresponding product
        $product = Product::where('name', $stock->product_name)->first();
        if ($product) {
            if ($product->quantity > $stock->quantity) {
                // Reduce the product quantity if it exceeds the stock quantity
                $product->update([
                    'quantity' => $product->quantity - $stock->quantity,
                ]);
            } else {
                // Delete the product if the stock quantity matches or exceeds the product quantity
                $product->delete();
            }
        }
        $stock->delete();

        return redirect()->route('stock.index')->with('success', 'Stock and corresponding product updated successfully!');
    }
}
