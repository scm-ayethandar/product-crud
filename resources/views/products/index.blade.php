@extends('layouts.master')

@section('title', 'Home Page')


@section('content')

<div class="container mt-5">
    @include('common.alert')

    <div class="row row-cols-3">
        @if (count($products) > 0)
        @foreach ($products as $product)
        <div class="mb-2">
            <div class="col rounded">
                <div class="card">
                    @if( $product->images->count())
                    <img src="{{ Storage::url($product->images[0]->path) }}" class="card-img-top" alt="..." style="width: 100%; height:150px; object-fit:cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text text-muted">$ {{ number_format($product->price) }}</p>
                        <p class="card-text">{{ $product->description }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <p>No Product.</p>
        @endif
        <div class=" mt-4 " style="width: 100%; margin:auto;">
        {{ $products->links() }}
        </div>
    </div>


    <div class="col-md-8">
        @if (count($products) > 0)
        @foreach ($products as $product)
        <div class="card mb-3">
            @if($product->images()->exists())
            {{-- <img src="{{ $product->images->first()->path }}" class="card-img-top" alt="..."> --}}
            <img src="{{ Storage::url($product->images[0]->path) }}" class="card-img-top" alt="...">
            @endif
            <div class="card-body">
                <h5 class="card-title h2">{{ $product->title }}</h5>
                <p class="text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-week-fill" viewBox="0 0 16 16">
                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM9.5 7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm3 0h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zM2 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                    </svg>
                    {{ $product->created_at->toFormattedDateString() }}
                </p>
                <p class="card-text text-muted">
                    {{ $product->description }}
                </p>
                <p class="card-text text-muted">
                    {{ $product->price }}
                </p>
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-success">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete?')">
                                @method('DELETE')
                                {{-- <input type="hidden" name="_method" value="DELETE"> --}}
                                @csrf
                                <button type="submit" class="btn btn-outline-danger ms-2">Delete</button>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary text-uppercase">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <p>No Post.</p>
        @endif
        {{ $products->links() }}
    </div>
</div>

@endsection