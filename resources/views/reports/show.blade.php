@extends('layouts.app')

@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2>Report Details</h2>
                        <p class="text-muted mb-0">Viewing approved assignments for this report</p>
                    </div>
                    <a href="{{ route('reports.view.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Reports
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h3>Report Information</h3>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $report->name }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{ $report->type }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $report->description }}</td>
                                </tr>
                                <tr>
                                    <th>Serial Number</th>
                                    <td>{{ $report->serial_number }}</td>
                                </tr>
                                <tr>
                                    <th>Specifications</th>
                                    <td>{{ $report->specifications }}</td>
                                </tr>
                                <tr>
                                    <th>Current Stock</th>
                                    <td>{{ $report->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Price Per Item</th>
                                    <td>{{ number_format($report->price_per_item, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $report->status }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3>Suppliers</h3>
                            @if($report->suppliers->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($report->suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->contact_number }}</td>
                                        <td>{{ $supplier->email }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-muted">No suppliers associated with this report.</p>
                            @endif
                        </div>
                    </div>

                    <h3>Approved Assignments</h3>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Employee</th>
                                    <th>Quantity Issued</th>
                                    <th>Issue Date</th>
                                    <th>Reason</th>
                                    <th>Notes</th>
                                    <th>Issued By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($report->inventoryIssues as $issue)
                                <tr>
                                    <td>{{ $issue->department->name ?? 'N/A' }}</td>
                                    <td>{{ $issue->employee->name ?? 'N/A' }}</td>
                                    <td>{{ $issue->quantity_issued }}</td>
                                    <td>{{ $issue->issue_date->format('M d, Y') }}</td>
                                    <td>{{ $issue->reason }}</td>
                                    <td>{{ $issue->notes }}</td>
                                    <td>{{ $issue->issued_by }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No approved assignments found for this report.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="text-muted">
                        <small>This is a view-only page. No editing or creation of assignments is allowed here.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection