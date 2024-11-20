@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}">
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

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <!-- Campo para el nombre del producto -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" value="{{ old('name') }}">
            </div>
        </div>

        <!-- Campo para la descripción -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" name="description" rows="3" placeholder="Enter product description">{{ old('description') }}</textarea>
            </div>
        </div>

        <!-- Campo para el precio -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Price:</strong>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter product price" value="{{ old('price') }}">
            </div>
        </div>

        <!-- Campo para la imagen -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Image:</strong>
                <input type="file" name="image" class="form-control">
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
