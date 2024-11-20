@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('products.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Campo para el nombre del producto -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" placeholder="Enter product name">
            </div>
        </div>

        <!-- Campo para la descripción -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" name="description" rows="3" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <!-- Campo para el precio -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Price:</strong>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="form-control" placeholder="Enter product price">
            </div>
        </div>

        <!-- Campo para la imagen -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Image:</strong>
                <input type="file" name="image" class="form-control">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-thumbnail mt-2" width="150">
                @endif
            </div>
        </div>

        <!-- Botón para enviar el formulario -->
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-3">
                <i class="fa-solid fa-floppy-disk"></i> Submit
            </button>
        </div>
    </div>
</form>
@endsection

