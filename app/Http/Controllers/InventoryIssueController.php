<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Department;
use App\Models\Employee;
use App\Models\InventoryIssue;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class InventoryIssueController extends Controller
{
    public function index()
    {
        $inventoryIssues = InventoryIssue::with(['product', 'department', 'employee'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('inventory-issues.index', compact('inventoryIssues'));
    }

    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $departments = Department::all();
        $employees = Employee::all();

        return view('inventory-issues.create', compact('products', 'departments', 'employees'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'stock_out_type' => 'required|in:Assigned,Disposed',
        'quantity_issued' => 'required|integer|min:1',
        'department_id' => 'required_if:stock_out_type,Assigned|exists:departments,id',
        'employee_id' => 'required_if:stock_out_type,Assigned|exists:employees,id',
        'notes' => 'nullable|string',
    ]);

    $product = Product::findOrFail($validated['product_id']);
    if ($product->quantity < $validated['quantity_issued']) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['quantity_issued' => 'Not enough stock available. Current stock: ' . $product->quantity]);
    }

    DB::beginTransaction();

    try {
       
        $inventoryIssue = InventoryIssue::create([
            'product_id' => $validated['product_id'],
            'stock_out_type' => $validated['stock_out_type'],
            'department_id' => $validated['stock_out_type'] === 'Assigned' ? $validated['department_id'] : null,
            'employee_id' => $validated['stock_out_type'] === 'Assigned' ? $validated['employee_id'] : null,
            'quantity_issued' => $validated['quantity_issued'],
            'notes' => $validated['notes'],
            'issued_by' => Auth::id(),
            'issue_date' => Carbon::now()->toDateString(),
        ]);

      
        $product->quantity -= $validated['quantity_issued'];
        $product->save();

        
        InventoryLog::create([
            'product_id' => $product->id,
            'type' => 'stock_out',
            'quantity' => $validated['quantity_issued'],
            'reference' => $inventoryIssue->id, 
            'remarks' => $validated['notes'],
        ]);

        DB::commit();

        return redirect()->route('inventory-issues.index')
            ->with('success', 'Inventory item issued successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Failed to issue inventory item: ' . $e->getMessage()]);
    }
}

    public function show($id)
{
    $inventoryIssue = InventoryIssue::with(['product', 'department', 'employee'])->findOrFail($id);
    return view('inventory-issues.show', compact('inventoryIssue'));
}
}