@extends('layouts.app')

@section('contents')
    <div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Create Purchase Order</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Purchase Orders
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Please check the form below for errors.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('purchase-orders.store') }}" method="POST" id="poForm">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="supplier_id">Supplier:</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ (request('supplier_id') == $supplier->id) ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Order Items</h5>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered" id="products-table">
                        <thead class="bg-light">
                            <tr>
                                <th>Product</th>
                                <th width="150px">Quantity</th>
                    
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="product-row">
                                <td>
                                    <select name="products[0][id]" class="form-control product-select" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->type }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="products[0][quantity]" class="form-control" value="1" min="1" required>
                                </td>
                               
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
                
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Create Purchase Order
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>

            // Update input names
            newRow.querySelectorAll('select, input').forEach(function(element) {
                const name = element.getAttribute('name');
                element.setAttribute('name', name.replace(/\[\d+\]/, `[${rowCount}]`));
                
                // Clear values
                if (element.tagName === 'SELECT') {
                    element.selectedIndex = 0;
                } else if (element.tagName === 'INPUT') {
                    element.value = 1;
                }
            });
            
            
        

        
       
        
        // Form validation
        document.getElementById('poForm').addEventListener('submit', function(e) {
            const supplierSelect = document.getElementById('supplier_id');
            if (!supplierSelect.value) {
                e.preventDefault();
                alert('Please select a supplier');
                return;
            }
            
            const productSelects = document.querySelectorAll('.product-select');
            let isValid = true;
            let selectedproducts = [];
            
            productSelects.forEach(function(select) {
                if (!select.value) {
                    isValid = false;
                } else if (selectedproducts.includes(select.value)) {
                    isValid = false;
                    alert('You have duplicate products. Please use the quantity field instead.');
                    e.preventDefault();
                } else {
                    selectedproducts.push(select.value);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please select all products before submitting');
            }
        });
    });
</script>
@endpush
@endsection