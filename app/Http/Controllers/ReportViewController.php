<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryIssue;
use Illuminate\Http\Request;

class ReportViewController extends Controller
{
    /**
     * Display a listing of approved reports with their assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get products that have been issued (have assignment records)
        $reports = Product::with(['inventoryIssues' => function ($query) {
            $query->where('status', 'approved');
        }, 'inventoryIssues.department', 'inventoryIssues.employee'])
            ->whereHas('inventoryIssues', function ($query) {
                $query->where('status', 'approved');
            })
            ->get();

        return view('reports.view', compact('reports'));
    }

    /**
     * Display the specified report and its approved assignments.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Product::with(['inventoryIssues' => function ($query) {
            $query->where('status', 'approved');
        }, 'inventoryIssues.department', 'inventoryIssues.employee'])
            ->findOrFail($id);

        return view('reports.show', compact('report'));
    }
}
