<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Search in products and stocks
        $products = Product::where('name', 'LIKE', "%$query%")->get();
        $stocks = Stock::where('product_name', 'LIKE', "%$query%")->get();

        return view('search.results', compact('products', 'stocks', 'query'));
    }
}
