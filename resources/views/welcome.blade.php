@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 class="text-center">Productos disponibles</h2>
        </div>
    </div>
</div>

<div class="row">
    @foreach ($products as $product)
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm">
                <!-- Imagen del producto -->
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">


                <!-- Contenido del producto -->
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center">{{ $product->name }}</h5>
                    <p class="card-text text-muted text-truncate">{{ $product->description }}</p>
                    <div class="mt-auto">
                        <h6 class="text-primary text-center">${{ number_format($product->price, 2) }}</h6>
                    </div>
                </div>

                <!-- Botón de acción -->
                <div class="card-footer text-center">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">más detalles</a>
                </div>


                <div class="card-footer text-center">
    <form action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit" class="btn btn-success btn-sm">Agregar al carrito</button>
    </form>
</div>


            </div>
        </div>
    @endforeach
</div>
@endsection
