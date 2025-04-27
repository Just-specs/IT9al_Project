<h2 class="text-center">Stock List</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Supplier</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $stock)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stock->product_name }}</td>
            <td>{{ $stock->quantity }}</td>
            <td>{{ $stock->supplier }}</td>
            <td>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $stock->id }}">Edit</button>
                <form action="{{ route('stock.destroy', $stock->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @include('stock.partials.edit-modal', ['stock' => $stock])
        @endforeach
    </tbody>
</table>