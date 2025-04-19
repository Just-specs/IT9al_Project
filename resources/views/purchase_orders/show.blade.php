@extends('layouts.app')

@section('title', 'Purchase Order Details')

@section('contents')
<h1>Purchase Order Details</h1>
<hr />
<div class="mb-3">
    <strong>Product Name:</strong> {{ $purchaseOrder->product_name }}
</div>
<div class="mb-3">
    <strong>Quantity:</strong> {{ $purchaseOrder->quantity }}
</div>
<div class="mb-3">
    <strong>Supplier:</strong> {{ $purchaseOrder->supplier->name ?? 'N/A' }}
</div>
<div class="mb-3">
    <strong>Status:</strong>
    @if($purchaseOrder->status == 'pending')
    <span class="badge bg-warning">Pending</span>
    @elseif($purchaseOrder->status == 'completed')
    <span class="badge bg-success">Completed</span>
    @else
    <span class="badge bg-danger">Cancelled</span>
    @endif
</div>
<a href="{{ route('purchase_orders.index') }}" class="btn btn-secondary">Back</a>
@endsection