<form action="{{ route('stock.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="product_name">Product Name</label>
        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" required>
    </div>
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity" required>
    </div>
    <div class="form-group">
        <label for="supplier">Supplier</label>
        <input type="text" name="supplier" id="supplier" class="form-control" placeholder="Enter supplier name" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Stock</button>
</form>