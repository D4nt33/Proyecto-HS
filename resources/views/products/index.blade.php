@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Products</h2>
        </div>
        <div class="pull-right">
            @can('product-create')
            <a class="btn btn-success btn-sm mb-2" href="{{ route('products.create') }}">
                <i class="fa fa-plus"></i> Create New Product
            </a>
            @endcan
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>
                @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-thumbnail" width="50">
                @else
                <span class="text-muted">No Image</span>
                @endif
            </td>
            <td>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    <a class="btn btn-info btn-sm" href="{{ route('products.show', $product->id) }}">
                        <i class="fa-solid fa-list"></i> Show
                    </a>
                    @can('product-edit')
                    <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    @endcan

                    @csrf
                    @method('DELETE')

                    @can('product-delete')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                    @endcan
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">No products found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {!! $products->links() !!}
</div>
@endsection
