@extends('layouts.app')

@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Generate New Report</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reports.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Report Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="report_type" class="form-label">Report Type</label>
                            <select class="form-select @error('report_type') is-invalid @enderror" id="report_type" name="report_type" required>
                                <option value="">Select Report Type</option>
                                <option value="inventory" {{ old('report_type') == 'inventory' ? 'selected' : '' }}>Inventory Report</option>
                                <option value="purchase_order" {{ old('report_type') == 'purchase_order' ? 'selected' : '' }}>Purchase Order Report</option>
                                <option value="issue" {{ old('report_type') == 'issue' ? 'selected' : '' }}>Issue Report</option>
                                <option value="supplier" {{ old('report_type') == 'supplier' ? 'selected' : '' }}>Supplier Report</option>
                                <option value="department" {{ old('report_type') == 'department' ? 'selected' : '' }}>Department Report</option>
                            </select>
                            @error('report_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Report Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Dynamic fields based on report type -->
                        <div id="inventory-params" class="report-params" style="display: none;">
                            <div class="mb-3">
                                <label for="min_stock_level" class="form-label">Minimum Stock Level (Optional)</label>
                                <input type="number" class="form-control @error('min_stock_level') is-invalid @enderror" id="min_stock_level" name="min_stock_level" value="{{ old('min_stock_level') }}">
                                @error('min_stock_level')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror>
                                <div class="form-text">If set, only products with quantity at or below this level will be included.</div>
                            </div>
                        </div>

                        <div id="purchase-order-params" class="report-params" style="display: none;">
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Supplier (Optional)</label>
                                <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                                    <option value="">All Suppliers</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div id="issue-params" class="report-params" style="display: none;">
                            <div class="mb-3">
                                <label for="department_id" class="form-label">Department (Optional)</label>
                                <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Generate Report</button>
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reportTypeSelect = document.getElementById('report_type');
        const paramDivs = document.querySelectorAll('.report-params');

        function showRelevantParams() {
            // Hide all parameter divs
            paramDivs.forEach(div => div.style.display = 'none');

            // Show relevant div based on selection
            const reportType = reportTypeSelect.value;
            if (reportType === 'inventory') {
                document.getElementById('inventory-params').style.display = 'block';
            } else if (reportType === 'purchase_order') {
                document.getElementById('purchase-order-params').style.display = 'block';
            } else if (reportType === 'issue') {
                document.getElementById('issue-params').style.display = 'block';
            }
        }

        // Initial setup
        showRelevantParams();

        // Update on change
        reportTypeSelect.addEventListener('change', showRelevantParams);
    });
</script>
@endpush
@endsection