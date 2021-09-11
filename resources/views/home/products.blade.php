@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            @foreach($products as $product)
                <div class="col-md-4  mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $product->price }} تومان </h6>
                        <p> </p>
                        <a href="{{ route('product.single',$product->id) }}" class="card-link mr-auto">جزئیات محصول </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
