@extends('layouts.app')

@section('title', 'Purchase Orders - Stock Out')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-0">Purchase Orders</h1>
    <a href="{{ route('purchase_orders.create') }}" class="btn btn-primary">Create Purchase Order</a>
</div>
<hr />
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif
<table class="table table-hover">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Supplier</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($purchaseOrders->count() > 0)
        @foreach($purchaseOrders as $order)
        <tr class="{{ $order->status == 'pending' ? 'table-warning' : ($order->status == 'completed' ? 'table-success' : 'table-danger') }}">
            <td class="align-middle">{{ $loop->iteration }}</td>
            <td class="align-middle">{{ $order->product_name }}</td>
            <td class="align-middle">{{ $order->quantity }}</td>
            <td class="align-middle">{{ $order->supplier->name ?? 'N/A' }}</td>
            <td class="align-middle">
                @if($order->status == 'pending')
                <span class="badge bg-warning">Pending</span>
                @elseif($order->status == 'completed')
                <span class="badge bg-success">Completed</span>
                @else
                <span class="badge bg-danger">Cancelled</span>
                @endif
            </td>
            <td class="align-middle">
                <div class="btn-group" role="group">
                    <a href="{{ route('purchase_orders.show', $order->id) }}" class="btn btn-secondary">Details</a>
                    <a href="{{ route('purchase_orders.edit', $order->id)}}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('purchase_orders.destroy', $order->id) }}" method="POST" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure you want to delete this order?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger m-0">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="6">No purchase orders found</td>
        </tr>
        @endif
    </tbody>
</table>
@endsection