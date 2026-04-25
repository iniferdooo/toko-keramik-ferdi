<div>
    <h2 style="color:red; font-size:24px;">PRODUK MUNCUL!</h2>
    @foreach($products as $product)
        <p>{{ $product->name }}</p>
    @endforeach
</div>