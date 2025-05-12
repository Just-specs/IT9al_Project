<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use Illuminate\Http\Request;

class InventoryLogController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryLog::with('product');

        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

     
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

      
        if ($request->filled('product_name')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product_name . '%');
            });
        }

     
        if ($request->filled('reference')) {
            $query->where('reference', $request->reference);
        }

     
        if ($request->filled('department_or_employee')) {
            $query->where('remarks', 'like', '%' . $request->department_or_employee . '%');
        }

        $logs = $query->latest()->paginate(10);

        return view('inventory-logs.index', compact('logs'));
    }
}
