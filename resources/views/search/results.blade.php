@extends('layouts.app')

@section('contents')
<h1>Search Results for "{{ $query }}"</h1>
<hr />

<a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>

<h2>Products</h2>
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
        @forelse($products as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->type }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->supplier->name ?? 'N/A' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No products found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<h2>Stocks</h2>
<table class="table table-hover">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Supplier</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stocks as $stock)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stock->product_name }}</td>
            <td>{{ $stock->quantity }}</td>
            <td>{{ $stock->supplier }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No stocks found</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection