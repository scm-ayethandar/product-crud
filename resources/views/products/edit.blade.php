@extends('layouts.master')

@section('title', 'Edit Product')

@section('content')

@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card">
    <div class="card-header">
        <h3>Edit Product</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" type="file" name="images[]" multiple>
                @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @foreach($errors->get('images.*') as $message)
                <div class="invalid-feedback">{{ $message[0] }}</div>
                @endforeach
            </div>

            <img src="{{ Storage::url($product->images[0]->path) }}" alt="Product Image">
            <div class="mb-3">
                <label class="form-label">Product Title</label>
                <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title', $product->title) }}">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Product description</label>
                <textarea class="form-control  @error('description') is-invalid @enderror" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Product Cateory</label>
                <select name="category_ids[]" class="form-select @error('category_ids') is-invalid @enderror" multiple>
                    <option value="">-- select --</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        @if (in_array($category->id, old('category_ids', $oldCategoryIds)))
                            selected
                        @endif
                        >{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_ids')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Product Price</label>
                <textarea class="form-control  @error('price') is-invalid @enderror" name="price" rows="5">{{ old('price', $product->price) }}</textarea>
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-outline-primary">Update</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection