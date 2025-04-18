@extends('layouts.app')

@section('title', 'Show Computer Part')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-0">Computer Part Details</h1>
    <div>
        <a href="{{ route('products') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
<hr />

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Basic Information
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Name:</div>
                    <div class="col-md-8">{{ $product->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Type:</div>
                    <div class="col-md-8">{{ $product->type }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        @if($product->status == 'available')
                        <span class="badge bg-success">Available</span>
                        @elseif($product->status == 'assigned')
                        <span class="badge bg-primary">Assigned</span>
                        @elseif($product->status == 'maintenance')
                        <span class="badge bg-warning">Maintenance</span>
                        @else
                        <span class="badge bg-danger">Retired</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Serial Number:</div>
                    <div class="col-md-8">{{ $product->serial_number ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Supplier:</div>
                    <div class="col-md-8">{{ $product->supplier->name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Inventory Information
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6 fw-bold">Current Quantity:</div>
                    <div class="col-md-6">
                        <span class="{{ $product->quantity <= $product->min_stock_level ? 'text-danger fw-bold' : '' }}">
                            {{ $product->quantity }}
                        </span>
                        @if($product->quantity <= $product->min_stock_level)
                        <span class="badge bg-danger">Low Stock</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 fw-bold">Minimum Stock Level:</div>
                    <div class="col-md-6">{{ $product->min_stock_level }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 fw-bold">Created At:</div>
                    <div class="col-md-6">{{ $product->created_at->format('Y-m-d H:i:s') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 fw-bold">Last Updated:</div>
                    <div class="col-md-6">{{ $product->updated_at->format('Y-m-d H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Description & Specifications
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-2 fw-bold">Description:</div>
                    <div class="col-md-10">{{ $product->description }}</div>
                </div>
                <div class="row">
                    <div class="col-md-2 fw-bold">Specifications:</div>
                    <div class="col-md-10">{{ $product->specifications ?? 'No specifications provided.' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Item History & Assignments (to be implemented) -->
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Item History & Assignments
            </div>
            <div class="card-body">
                <!-- Add tabs for history, assignments, etc. -->
                <ul class="nav nav-tabs" id="itemTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments" type="button" role="tab" aria-controls="assignments" aria-selected="true">Assignments</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">Stock History</button>
                    </li>
                </ul>
                <div class="tab-content p-3" id="itemTabsContent">
                    <div class="tab-pane fade show active" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                        <p>No assignment records found for this item.</p>
                    </div>
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                        <p>No stock history records found for this item.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection