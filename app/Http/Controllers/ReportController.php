<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Department;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index()
    {
        try {
            $reports = Report::with('user')->orderBy('created_at', 'desc')->get();
            return view('reports.index', compact('reports'));
        } catch (\Exception $e) {
            Log::error('Error in reports index: ' . $e->getMessage());
            return view('reports.index', ['reports' => collect([])])->with('error', 'Error loading reports.');
        }
    }

    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        try {
            $suppliers = Supplier::orderBy('name')->get();
            $departments = Department::orderBy('name')->get();
            return view('reports.create', compact('suppliers', 'departments'));
        } catch (\Exception $e) {
            Log::error('Error in reports create: ' . $e->getMessage());
            return redirect()->route('reports.index')->with('error', 'Error loading report creation form.');
        }
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'report_type' => 'required|in:inventory,purchase_order,issue,supplier,department',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'min_stock_level' => 'nullable|integer|min:0',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'department_id' => 'nullable|exists:departments,id',
            ]);

            // Extract parameters based on report type
            $parameters = [];
            switch ($validated['report_type']) {
                case 'inventory':
                    if (!empty($validated['min_stock_level'])) {
                        $parameters['min_stock_level'] = $validated['min_stock_level'];
                    }
                    break;
                case 'purchase_order':
                    if (!empty($validated['supplier_id'])) {
                        $parameters['supplier_id'] = $validated['supplier_id'];
                    }
                    break;
                case 'issue':
                    if (!empty($validated['department_id'])) {
                        $parameters['department_id'] = $validated['department_id'];
                    }
                    break;
            }

            // Generate report data based on type and parameters
            $reportData = $this->generateReportData(
                $validated['report_type'],
                $validated['start_date'],
                $validated['end_date'],
                $parameters
            );

            $report = Report::create([
                'title' => $validated['title'],
                'report_type' => $validated['report_type'],
                'generated_by' => Auth::id(),
                'report_date' => now(),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'parameters' => !empty($parameters) ? json_encode($parameters) : null,
                'data' => !empty($reportData) ? json_encode($reportData) : null,
            ]);

            return redirect()->route('reports.show', $report->id)
                ->with('success', 'Report generated successfully!');
        } catch (\Exception $e) {
            Log::error('Error in reports store: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error generating report: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified report.
     */
    public function show(Report $report)
    {
        try {
            // Ensure data is properly decoded
            if (is_string($report->data)) {
                $report->data = json_decode($report->data, true);
            }

            if (is_string($report->parameters)) {
                $report->parameters = json_decode($report->parameters, true);
            }

            return view('reports.show', compact('report'));
        } catch (\Exception $e) {
            Log::error('Error in reports show: ' . $e->getMessage());
            return redirect()->route('reports.index')->with('error', 'Error viewing report.');
        }
    }

    /**
     * Remove the specified report from storage.
     */
    public function destroy(Report $report)
    {
        try {
            $report->delete();
            return redirect()->route('reports.index')
                ->with('success', 'Report deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in reports destroy: ' . $e->getMessage());
            return redirect()->route('reports.index')->with('error', 'Error deleting report.');
        }
    }

    /**
     * Generate report data based on type and parameters.
     */
    private function generateReportData($type, $startDate, $endDate, $parameters = [])
    {
        try {
            switch ($type) {
                case 'inventory':
                    return $this->generateInventoryReport($startDate, $endDate, $parameters);
                case 'purchase_order':
                    return $this->generatePurchaseOrderReport($startDate, $endDate, $parameters);
                case 'issue':
                    return $this->generateIssueReport($startDate, $endDate, $parameters);
                case 'supplier':
                    return $this->generateSupplierReport($startDate, $endDate);
                case 'department':
                    return $this->generateDepartmentReport($startDate, $endDate);
                default:
                    return [];
            }
        } catch (\Exception $e) {
            Log::error('Error generating report data: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Error generating report data'
            ];
        }
    }

    // These are placeholder methods - implement with your actual data retrieval logic

    private function generateInventoryReport($startDate, $endDate, $parameters)
    {
        // Simple placeholder data
        return [
            'total_products' => 5,
            'total_value' => 1250.00,
            'low_stock_items' => 2,
            'products' => [
                [
                    'id' => 1,
                    'name' => 'Sample Product 1',
                    'type' => 'Component',
                    'quantity' => 15,
                    'price_per_item' => 25.00,
                    'min_stock_level' => 10,
                    'status' => 'Active',
                    'total_value' => 375.00
                ],
                [
                    'id' => 2,
                    'name' => 'Sample Product 2',
                    'type' => 'Tool',
                    'quantity' => 5,
                    'price_per_item' => 75.00,
                    'min_stock_level' => 8,
                    'status' => 'Low Stock',
                    'total_value' => 375.00
                ],
                [
                    'id' => 3,
                    'name' => 'Sample Product 3',
                    'type' => 'Raw Material',
                    'quantity' => 100,
                    'price_per_item' => 5.00,
                    'min_stock_level' => 20,
                    'status' => 'Active',
                    'total_value' => 500.00
                ]
            ]
        ];
    }

    private function generatePurchaseOrderReport($startDate, $endDate, $parameters)
    {
        // Simple placeholder data
        return [
            'total_orders' => 3,
            'total_amount' => 2750.00,
            'by_status' => [
                'pending' => 1,
                'approved' => 1,
                'received' => 1,
                'cancelled' => 0,
            ],
            'purchase_orders' => [
                [
                    'id' => 1,
                    'supplier' => 'Supplier A',
                    'total_amount' => 1250.00,
                    'status' => 'approved',
                    'created_at' => '2025-05-01',
                    'items_count' => 3
                ],
                [
                    'id' => 2,
                    'supplier' => 'Supplier B',
                    'total_amount' => 750.00,
                    'status' => 'pending',
                    'created_at' => '2025-05-03',
                    'items_count' => 2
                ],
                [
                    'id' => 3,
                    'supplier' => 'Supplier A',
                    'total_amount' => 750.00,
                    'status' => 'received',
                    'created_at' => '2025-04-25',
                    'items_count' => 2
                ]
            ]
        ];
    }

    private function generateIssueReport($startDate, $endDate, $parameters)
    {
        // Simple placeholder data
        return [
            'total_issues' => 3,
            'total_items_issued' => 12,
            'issues' => [
                [
                    'id' => 1,
                    'product' => 'Product A',
                    'employee' => 'John Doe',
                    'department' => 'Production',
                    'quantity_issued' => 5,
                    'issue_date' => '2025-05-02',
                    'reason' => 'Regular production needs'
                ],
                [
                    'id' => 2,
                    'product' => 'Product B',
                    'employee' => 'Jane Smith',
                    'department' => 'Maintenance',
                    'quantity_issued' => 2,
                    'issue_date' => '2025-05-04',
                    'reason' => 'Equipment repair'
                ],
                [
                    'id' => 3,
                    'product' => 'Product C',
                    'employee' => 'Bob Johnson',
                    'department' => 'R&D',
                    'quantity_issued' => 5,
                    'issue_date' => '2025-05-05',
                    'reason' => 'New prototype testing'
                ]
            ]
        ];
    }

    private function generateSupplierReport($startDate, $endDate)
    {
        // Simple placeholder data
        return [
            'total_suppliers' => 2,
            'total_orders' => 5,
            'total_amount' => 3750.00,
            'suppliers' => [
                [
                    'id' => 1,
                    'name' => 'Supplier A',
                    'contact_number' => '123-456-7890',
                    'email' => 'contact@suppliera.com',
                    'orders_count' => 3,
                    'total_amount' => 2250.00
                ],
                [
                    'id' => 2,
                    'name' => 'Supplier B',
                    'contact_number' => '098-765-4321',
                    'email' => 'contact@supplierb.com',
                    'orders_count' => 2,
                    'total_amount' => 1500.00
                ]
            ]
        ];
    }

    private function generateDepartmentReport($startDate, $endDate)
    {
        // Simple placeholder data
        return [
            'total_departments' => 3,
            'total_issues' => 8,
            'total_items_issued' => 25,
            'departments' => [
                [
                    'id' => 1,
                    'name' => 'Production',
                    'issues_count' => 4,
                    'total_items' => 15,
                    'top_products' => [
                        ['name' => 'Product A', 'quantity' => 8],
                        ['name' => 'Product C', 'quantity' => 7]
                    ]
                ],
                [
                    'id' => 2,
                    'name' => 'Maintenance',
                    'issues_count' => 2,
                    'total_items' => 5,
                    'top_products' => [
                        ['name' => 'Product B', 'quantity' => 3],
                        ['name' => 'Product D', 'quantity' => 2]
                    ]
                ],
                [
                    'id' => 3,
                    'name' => 'R&D',
                    'issues_count' => 2,
                    'total_items' => 5,
                    'top_products' => [
                        ['name' => 'Product E', 'quantity' => 3],
                        ['name' => 'Product F', 'quantity' => 2]
                    ]
                ]
            ]
        ];
    }
}
