@extends('layouts.app')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-0">Edit Purchase Order</h1>
    <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">Back</a>
</div>
<hr />
<form action="{{ route('purchase-orders.update', $purchaseOrder->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="supplier_id" class="form-label">Supplier</label>
        <select class="form-control" id="supplier_id" name="supplier_id" required>
            @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ $supplier->id == $purchaseOrder->supplier_id ? 'selected' : '' }}>
                {{ $supplier->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="draft" {{ $purchaseOrder->status == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="pending" {{ $purchaseOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="cancelled" {{ $purchaseOrder->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>

    @if ($purchaseOrder->status == 'draft')
    <div class="mb-3">
        <label for="order_details" class="form-label">Order Details</label>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity Ordered</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>
                        <input type="number" class="form-control" name="order_details[{{ $detail->id }}][quantity_ordered]" value="{{ $detail->quantity_ordered }}" min="1" required>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <button type="submit" class="btn btn-warning">Update</button>
</form>
@endsection