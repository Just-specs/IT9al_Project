<table class="table table-hover">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Supplier</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if($stocks->count() > 0)
        @foreach($stocks as $stock)
        <tr>
            <td class="align-middle">{{ $loop->iteration }}</td>
            <td class="align-middle">{{ $stock->product_name }}</td>
            <td class="align-middle">{{ $stock->quantity }}</td>
            <td class="align-middle">{{ $stock->supplier }}</td>
            <td class="align-middle">
                <form action="{{ route('stock.destroy', $stock->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this stock?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @include('stock.partials.edit-modal', ['stock' => $stock])
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="5">No stock records found</td>
        </tr>
        @endif
    </tbody>
</table>