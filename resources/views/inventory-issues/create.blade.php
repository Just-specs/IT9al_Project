@extends('layouts.app')

@section('contents')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Create Inventory Issue</h1>

    <form action="{{ route('inventory-issues.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->quantity }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="stock_out_type">Stock-Out Type</label>
            <select name="stock_out_type" id="stock_out_type" class="form-control" required>
                <option value="">Select Type</option>
                <option value="Assigned">Assigned</option>
                <option value="Disposed">Disposed</option>
            </select>
        </div>

        <div id="assigned-fields" style="display: none;">
            <div class="form-group">
                <label for="department_id">Department</label>
                <select name="department_id" id="department_id" class="form-control">
                    <option value="">Select Department</option>
                    @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="employee_id">Employee</label>
                <select name="employee_id" id="employee_id" class="form-control">
                    <option value="">Select Employee</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="quantity_issued">Quantity to Issue</label>
            <input type="number" name="quantity_issued" id="quantity_issued" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control"></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('inventory-issues.index') }}" class="btn btn-secondary">Close</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('stock_out_type').addEventListener('change', function () {
        const type = this.value;
        const assignedFields = document.getElementById('assigned-fields');

        if (type === 'Assigned') {
            assignedFields.style.display = 'block';
            document.getElementById('department_id').required = true;
            document.getElementById('employee_id').required = true;
        } else {
            assignedFields.style.display = 'none';
            document.getElementById('department_id').required = false;
            document.getElementById('employee_id').required = false;
        }
    });

    document.getElementById('department_id').addEventListener('change', function () {
        const departmentId = this.value;
        const employeeSelect = document.getElementById('employee_id');

        // Clear existing options
        employeeSelect.innerHTML = '<option value="">Select Employee</option>';

        if (departmentId) {
            // Fetch employees for the selected department
            fetch(`/departments/${departmentId}/employees`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(employee => {
                        const option = document.createElement('option');
                        option.value = employee.id;
                        option.textContent = employee.name;
                        employeeSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching employees:', error));
        }
    });
</script>
@endsection
