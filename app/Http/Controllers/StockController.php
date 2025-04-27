<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock; // Ensure the Stock model is imported

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all(); // Fetch all stock records
        return view('stock.index', compact('stocks')); // Pass $stocks to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'supplier' => 'required|string|max:255',
        ]);

        Stock::create($request->all()); // Save stock data to the database

        return redirect()->route('stock.index')->with('success', 'Stock added successfully!');
    }
}
