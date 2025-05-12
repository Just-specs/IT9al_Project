@extends('layouts.app')

@section('contents')
<div class="container-fluid"> 
    <h1 class="h3 mb-4 text-gray-800">Inventory Logs</h1>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Logs</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('inventory-logs.index') }}">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="form-label">Stock Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">All</option>
                            <option value="stock_in" {{ request('type') == 'stock_in' ? 'selected' : '' }}>Stock In</option>
                            <option value="stock_out" {{ request('type') == 'stock_out' ? 'selected' : '' }}>Stock Out</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="product_name" class="form-label">Product</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Search Product" value="{{ request('product_name') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="reference" class="form-label">Reference ID</label>
                        <input type="text" name="reference" id="reference" class="form-control" placeholder="Reference ID" value="{{ request('reference') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="department_or_employee" class="form-label">Department/Employee</label>
                        <input type="text" name="department_or_employee" id="department_or_employee" class="form-control" placeholder="Search" value="{{ request('department_or_employee') }}">
                    </div>
                    <div class="col-md-6 align-self-end">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('inventory-logs.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Inventory Logs Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Reference</th>
                        <th>Remarks</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->product->name }}</td>
                            <td>
                                <span class="badge {{ $log->type == 'stock_in' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucfirst($log->type) }}
                                </span>
                            </td>
                            <td>{{ $log->quantity }}</td>
                            <td>{{ $log->reference }}</td>
                            <td>{{ $log->remarks }}</td>
                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection