@extends('layouts.app')

@section('contents')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold mb-0">Purchase Order #{{ $purchaseOrder->id }}</h2>
        <span class="badge bg-{{ $purchaseOrder->status == 'pending' ? 'warning' : ($purchaseOrder->status == 'received' ? 'success' : ($purchaseOrder->status == 'approved' ? 'info' : 'primary')) }} ms-2">
            {{ ucfirst($purchaseOrder->status) }}
        </span>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary me-2">Back to List</a>
        @if($purchaseOrder->status == 'pending')
            <form action="{{ route('purchase-orders.update-status', $purchaseOrder->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="approved">
                <button type="submit" class="btn btn-primary">Approve</button>
            </form>
        @endif
        @if($purchaseOrder->status == 'approved')
            <a href="{{ route('purchase-orders.receive-form', $purchaseOrder->id) }}" class="btn btn-success">Record Receiving</a>
        @endif
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-6">
                <strong>Supplier:</strong> {{ $purchaseOrder->supplier->name }}
            </div>
            <div class="col-md-6">
                <strong>Total Amount:</strong> ${{ number_format($purchaseOrder->total_amount, 2) }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <strong>Order Date:</strong> {{ $purchaseOrder->created_at->format('M d, Y') }}
            </div>
            <div class="col-md-6">
                <strong>Last Updated:</strong> {{ $purchaseOrder->updated_at->format('M d, Y h:i A') }}
            </div>
        </div>
    </div>
</div>

<h4 class="fw-semibold mb-3">Order Items</h4>
<div class="card mb-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Type</th>
                        <th class="text-end">Quantity Ordered</th>
                        <th class="text-end">Price per Item</th>
                        <th class="text-end">Total Price</th>
                        <th class="text-end">Quantity Received</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrder->products as $item)
                    <tr>
                        <td>{{ $item->description ?? 'Product not found' }}</td>
                        <td>{{ $item->type ?? '-' }}</td>
                        <td class="text-end">{{ $item->pivot->quantity_ordered ?? 0 }}</td>
                        <td class="text-end">${{ number_format($item->pivot->price_per_item ?? 0, 2) }}</td>
                        <td class="text-end">${{ number_format(($item->pivot->price_per_item ?? 0) * ($item->pivot->quantity_ordered ?? 0), 2) }}</td>
                        <td class="text-end">0</td> <!-- Placeholder for received quantity -->
                        <td>
                            <span class="badge bg-warning">Pending</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No items found for this purchase order.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($purchaseOrder->receivings && $purchaseOrder->receivings->count() > 0)
<h4 class="fw-semibold mb-3">Receiving History</h4>
<div class="card mb-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date Received</th>
                        <th>Item</th>
                        <th class="text-end">Quantity Received</th>
                        <th>Received By</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchaseOrder->receivings as $receiving)
                    <tr>
                        <td>{{ $receiving->received_date->format('M d, Y') }}</td>
                        <td>{{ $receiving->orderDetail->product->description ?? 'Product not found' }}</td>
                        <td class="text-end">{{ $receiving->quantity_received }}</td>
                        <td>{{ $receiving->received_by }}</td>
                        <td>{{ $receiving->notes }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
    <p class="text-center text-muted">No receiving history found for this purchase order.</p>
@endif
@endsection
