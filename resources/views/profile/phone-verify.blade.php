@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                       شماره موبایل فعال
                    </div>

                    <div class="card-body">
                        <form action="{{ route('post.phone.verify') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="token" class="col-form-label">توکن</label>
                                <input type="text" name="token" id="token"
                                       class="form-control @error('token') is-invalid @enderror " placeholder="Enter Your Token" >
                                @error('token')
                                <span class="invalid-feedback">
                                    <strong> {{ $message }} </strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">اعتبار سنجی توکن</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
