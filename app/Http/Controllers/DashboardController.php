<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\Department;
use App\Models\InventoryIssue;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();
        $totalPurchaseOrders = PurchaseOrder::count(); // Add this line

        // Get low stock items
        $lowStockItems = Product::whereRaw('quantity <= min_stock_level')->count();

        // Get items by status
        $itemsByStatus = Product::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Get recent inventory activities
        $recentActivities = InventoryIssue::with(['product', 'employee'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get pending purchase orders
        $pendingOrders = PurchaseOrder::where('status', 'pending')
            ->with('supplier')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalSuppliers',
            'totalEmployees',
            'totalDepartments',
            'lowStockItems',
            'itemsByStatus',
            'recentActivities',
            'pendingOrders',
            'totalPurchaseOrders'
        ));
    }

    public function employeeDashboard()
    {
        $totalProducts = Product::count();
        $lowStockItems = Product::where('quantity', '<', 10)->count();
        $totalSuppliers = Supplier::count();
        $totalPurchaseOrders = PurchaseOrder::count();
        $recentActivities = InventoryIssue::with(['product', 'employee'])->latest()->take(5)->get();
        $pendingOrders = PurchaseOrder::where('status', 'pending')->get();
        $itemsByStatus = Product::selectRaw('status, COUNT(*) as total')->groupBy('status')->get();

        return view('employees.dashboard', compact(
            'totalProducts',
            'lowStockItems',
            'totalSuppliers',
            'totalPurchaseOrders',
            'recentActivities',
            'pendingOrders',
            'itemsByStatus'
        ));
    }
}
