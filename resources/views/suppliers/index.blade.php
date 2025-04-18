@extends('layouts.app')

@section('title', 'Suppliers')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-0">Suppliers</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add New Supplier</a>
</div>
<hr />
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif
<table class="table table-hover">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($suppliers->count() > 0)
        @foreach($suppliers as $supplier)
        <tr>
            <td class="align-middle">{{ $loop->iteration }}</td>
            <td class="align-middle">{{ $supplier->name }}</td>
            <td class="align-middle">{{ $supplier->contact_number }}</td>
            <td class="align-middle">{{ $supplier->email }}</td>
            <td class="align-middle">
                <div class="btn-group" role="group">
                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-secondary">Details</a>
                    <a href="{{ route('suppliers.edit', $supplier->id)}}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure you want to delete this supplier?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger m-0">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="5">No suppliers found</td>
        </tr>
        @endif
    </tbody>
</table>
@endsection