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
        <label for="price_per_product">Price per Product</label>
        <input type="number" name="price_per_product" id="price_per_product" class="form-control" placeholder="Enter price per product" required>
    </div>
    <div class="form-group">
        <label for="supplier">Supplier</label>
        <select name="supplier" id="supplier" class="form-control" required>
            <option value="" disabled selected>Select a supplier</option>
            @foreach($suppliers as $supplier)
            <option value="{{ $supplier->name }}">{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Add Stock</button>
</form>
<script>
    document.getElementById('quantity').addEventListener('input', function() {
        const quantity = parseFloat(this.value) || 0;
        const priceInput = document.getElementById('price_per_product');
        const basePrice = parseFloat(priceInput.dataset.basePrice) || 0;
        priceInput.value = basePrice * quantity;
    });
</script>