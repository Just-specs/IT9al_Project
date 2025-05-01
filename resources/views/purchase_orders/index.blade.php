@extends('layouts.app')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-0">Purchase Orders</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" onclick="$('#createPurchaseOrderModal').modal('show')">
        Create Purchase Order
    </button>
</div>
<hr />
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif

<!-- Purchase Orders Table -->
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
                    <form action="{{ route('purchase_orders.destroy', $order->id) }}" method="POST" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure you want to delete this order?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger m-0">Delete</button>
                    </form>
                </div>
            </td>
        </tr>

        <!-- Edit Purchase Order Modal -->
        <div class="modal fade" id="editPurchaseOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="editPurchaseOrderModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPurchaseOrderModalLabel{{ $order->id }}">Edit Purchase Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('purchase-orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="product_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $order->product_name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $order->quantity) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select class="form-control" id="supplier_id" name="supplier_id" required>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $supplier->id == $order->supplier_id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="6">No purchase orders found</td>
        </tr>
        @endif
    </tbody>
</table>

<!-- Create Purchase Order Modal -->
<div class="modal fade" id="createPurchaseOrderModal" tabindex="-1" aria-labelledby="createPurchaseOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPurchaseOrderModalLabel">Create Purchase Order</h5>
                <button type="button" class="btn btn-light border-0" onclick="$('#createPurchaseOrderModal').modal('hide')" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('purchase-orders.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <select class="form-control" id="product_name" name="product_name" required>
                            <option value="" disabled selected>Select Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->name }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@endsection