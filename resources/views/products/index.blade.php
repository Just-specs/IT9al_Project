@extends('layouts.app')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-0">Computer Parts Inventory</h1>
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
            <th>Name</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Supplier</th>
        </tr>
    </thead>
    <tbody>
        @if($products->count() > 0)
        @foreach($products as $product)
        <tr class="{{ $product->quantity <= $product->min_stock_level ? 'table-danger' : '' }}">
            <td class="align-middle">{{ $loop->iteration }}</td>
            <td class="align-middle">{{ $product->name }}</td>
            <td class="align-middle">{{ $product->type }}</td>
            <td class="align-middle">{{ $product->quantity }}</td>
            <td class="align-middle">
                @if($product->status == 'available')
                <span class="badge bg-success">Available</span>
                @elseif($product->status == 'assigned')
                <span class="badge bg-primary">Assigned</span>
                @elseif($product->status == 'maintenance')
                <span class="badge bg-warning">Maintenance</span>
                @else
                <span class="badge bg-danger">Retired</span>
                @endif
            </td>
            <td class="align-middle">{{ $product->supplier->name ?? 'N/A' }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="6">No products found</td>
        </tr>
        @endif
    </tbody>
</table>
@endsection