@extends('layouts.app')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-0">Stock List</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stockInModal" onclick="$('#stockInModal').modal('show')">
        Add Stock
    </button>
</div>
<hr />
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif

@include('stock.partials.table')

<!-- Modal -->
<div class="modal fade" id="stockInModal" tabindex="-1" aria-labelledby="stockInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockInModalLabel">Add Stock</h5>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="$('#stockInModal').modal('hide')">
                    <i class="fas fa-times"></i>
                </button>

            </div>
            <div class="modal-body">
                @include('stock.partials.form')
            </div>
        </div>
    </div>
</div>
@endsection