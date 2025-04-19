@extends('layouts.app')

@section('title', 'Create Purchase Order')

@section('contents')
<h1>Create Purchase Order</h1>
<hr />
<form action="{{ route('purchase-orders.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="product_name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="product_name" name="product_name" required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" required>
    </div>
    <div class="mb-3">
        <label for="supplier_id" class="form-label">Supplier</label>
        <select class="form-control" id="supplier_id" name="supplier_id" required>
            <option value="" disabled selected>Select Supplier</option>
            @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection