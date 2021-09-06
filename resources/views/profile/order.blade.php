@extends('profile.layout')

@section('main')
    <h4>لیست سفارشات</h4>
    <table class="table ">
        <tbody>
        <tr>
            <th>شماره سفارش</th>
            <th>عنوان</th>
            <th>تعداد</th>
        </tr>
        @foreach($order->products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->title }} </td>
                <td>{{  $product->pivot->quantity }} </td>
            </tr>
        @endforeach

        </tbody></table>
@endsection
