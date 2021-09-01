@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">
                        {{ $product->title }}
                    </div>
                    <div class="card-body">

                        <p class="card-text">
                            {{ $product->description }}
                        </p>
                        <h5 class="card-title">
                            قیمت
                            {{ $product->price }}
                        </h5>
                        <p class="card-text">
                            تعداد موجودی
                            {{ $product->inventory }}
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        تعداد بازدید
                        {{ $product->viewCount }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
