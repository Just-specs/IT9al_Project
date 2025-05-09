<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Department;
use App\Models\Employee;
use App\Models\InventoryIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryIssueController extends Controller
{
    /**
     * Display a listing of inventory issues.
     */
    public function index()
    {
        $inventoryIssues = InventoryIssue::with(['product', 'department', 'employee', 'issuedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('inventory-issues.index', compact('inventoryIssues'));
    }

    /**
     * Show the form for creating a new inventory issue.
     */
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $departments = Department::all();
        $employees = Employee::all();
        
        return view('inventory-issues.create', compact('products', 'departments', 'employees'));
    }

    /**
     * Store a newly created inventory issue in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'employee_id' => 'required|exists:employees,id',
            'department_id' => 'required|exists:departments,id',
            'quantity' => 'required|integer|min:1', 
            'issue_date' => 'required|date',
            
        ]);

        // Check product stock availability
        $product = Product::findOrFail($request->product_id);
        if ($product->quantity < $request->quantity) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['quantity' => 'Not enough stock available. Current stock: ' . $product->quantity]);
        }

        // Begin database transaction
        DB::beginTransaction();

        try {
            // Create the inventory issue
            $inventoryIssue = new InventoryIssue([
                'product_id' => $validated['product_id'],
                'employee_id' => $validated['employee_id'],
                'department_id' => $validated['department_id'],
                'quantity_issued' => $validated['quantity'], // Use quantity_issued here
                'issue_date' => $validated['issue_date'],

            ]);
            $inventoryIssue->issued_by = Auth::id();
            $inventoryIssue->save();

            // Update product quantity by subtracting the issued amount
            $product->quantity -= $validated['quantity'];
            $product->save();

            // Commit the transaction
            DB::commit();

            return redirect()->route('inventory-issues')
                ->with('success', 'Inventory item issued successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Log the error for debugging
            \Log::error('Failed to issue inventory item: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to issue inventory item: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified inventory issue.
     */
    public function show(InventoryIssue $inventoryIssue)
    {
        $inventoryIssue->load(['product', 'department', 'employee', 'issuedBy']);
        
        return view('inventory-issues.show', compact('inventoryIssue'));
    }

    /**
     * Get employees based on department ID
     */
    public function getEmployeesByDepartment($departmentId)
    {
        $employees = Employee::where('department_id', $departmentId)->get();
        
        return response()->json($employees);
    }
}