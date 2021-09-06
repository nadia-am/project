@extends('profile.layout')

@section('main')
    <h4>احراز هویت دو مرحله ای</h4>
    <br>
    @if( $errors->any() )
        <div class="alert alert-danger">
            <ul>
                @foreach( $errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>
        </div>
    @endif
    <form action="{{ route('manage.profile.2fa') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="type">نوع</label>
            <select name="type" id="type" class="form-control">
                @foreach( config('twoFactor.types') as $key=>$value)
                    <option value="{{ $key }}" {{ old('two_factor_auth') || auth()->user()->hasTwoFactor($key) ? 'selected':'' }} >
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="phone">شماره موبایل</label>
            <input type="text" name="phone" id="phone"
                   class="form-control"
                   placeholder="please enter your phone number"
                   value="{{ old('phone') ?? auth()->user()->phone_number }}" >
        </div>
        <div class="form-group">
            <button class="btn btn-primary">ویرایش</button>
        </div>
    </form>
@endsection
