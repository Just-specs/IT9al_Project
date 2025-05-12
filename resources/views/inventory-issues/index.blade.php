@extends('layouts.app')

@section('contents')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-4 text-gray-800">Stock Out</h1>
        <a href="{{ route('inventory-issues.create') }}" class="btn btn-primary">New Stock Out</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Department</th>
                        <th>Employee</th>
                        <th>Quantity Issued</th>
                        <th>Issue Date</th>
                        <th>Issued By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventoryIssues as $issue)
                        <tr>
                            <td>{{ $issue->id }}</td>
                            <td>{{ $issue->product->name }}</td>
                            <td>{{ $issue->department->name ?? 'N/A' }}</td>
                            <td>{{ $issue->employee->name ?? 'N/A' }}</td>
                            <td>{{ $issue->quantity_issued }}</td>
                            <td>{{ $issue->issue_date->format('Y-m-d') }}</td>
                            <td>{{ $issue->issued_by ? \App\Models\User::find($issue->issued_by)->name : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('inventory-issues.show', $issue->id) }}" class="btn btn-info btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $inventoryIssues->links() }}
        </div>
    </div>
</div>
@endsection
