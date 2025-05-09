@extends('layouts.app')

@section('contents')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Inventory Issue</h1>
        <a href="{{ route('inventory-issues') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

   

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Issue Inventory Item</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('inventory-issues.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_id">Product <span class="text-danger">*</span></label>
                            <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-stock="{{ $product->quantity }}">
                                        {{ $product->name }} (Available: {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
                            <small id="stock_warning" class="form-text text-danger" style="display: none;">
                                Not enough stock available!
                            </small>
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_id">Department <span class="text-danger">*</span></label>
                            <select class="form-control @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required>
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee_id">Employee <span class="text-danger">*</span></label>
                            <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="issue_date">Issue Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required>
                            @error('issue_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reason">Reason <span class="text-danger">*</span></label>
                            <select class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" required>
                                <option value="">Select Reason</option>
                                <option value="New Assignment">New Assignment</option>
                                <option value="Replacement">Replacement</option>
                                <option value="Temporary Use">Temporary Use</option>
                                <option value="Project Requirement">Project Requirement</option>
                                <option value="Repair/Maintenance">Repair/Maintenance</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Issue Item</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
       
        $('#product_id, #quantity').on('change', function() {
            const productSelect = $('#product_id');
            const selectedOption = productSelect.find('option:selected');
            const availableStock = parseInt(selectedOption.data('stock')) || 0;
            const requestedQuantity = parseInt($('#quantity').val()) || 0;
            
            console.log("Available stock:", availableStock, "Requested quantity:", requestedQuantity);
            
            if (productSelect.val() && requestedQuantity > availableStock) {
                $('#stock_warning').show();
                $('#stock_warning').text('Not enough stock available. Current stock: ' + availableStock);
            } else {
                $('#stock_warning').hide();
            }
        });
        
      
        $('#department_id').on('change', function() {
            const departmentId = $(this).val();
            if (departmentId) {
                $.ajax({
                    url: '/departments/' + departmentId + '/employees',
                    type: 'GET',
                    success: function(data) {
                        $('#employee_id').empty();
                        $('#employee_id').append('<option value="">Select Employee</option>');
                        $.each(data, function(key, value) {
                            $('#employee_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#employee_id').empty();
                $('#employee_id').append('<option value="">Select Employee</option>');
            }
        });
    });
</script>
@endsection