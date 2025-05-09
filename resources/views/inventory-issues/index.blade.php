@extends('layouts.app')


@section('contents')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Inventory Issues</h1>
        <a href="{{ route('inventory-issues.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Inventory Issue
        </a>
    </div>

    

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Inventory Issues</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Department</th>
                            <th>Employee</th>
                            <th>Quantity</th>
                            <th>Issue Date</th>
                            <th>Reason</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventoryIssues as $issue)
                        <tr>
                            <td>{{ $issue->id }}</td>
                            <td>{{ $issue->product->name }}</td>
                            <td>{{ $issue->department->name }}</td>
                            <td>{{ $issue->employee->name }}</td>
                            <td>{{ $issue->quantity }}</td>
                            <td>{{ $issue->issue_date->format('Y-m-d') }}</td>
                            <td>{{ Str::limit($issue->reason, 30) }}</td>
                            <td>
                                <a href="{{ route('inventory-issues.show', $issue->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="d-flex justify-content-center">
                    {{ $inventoryIssues->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "info": false,
        });
    });
</script>
@endsection