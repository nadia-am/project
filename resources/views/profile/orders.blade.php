@extends('profile.layout')

@section('main')
    <h4>سفارشات شما</h4>
    <table class="table ">
        <tbody>
        <tr>
            <th>شماره سفارش</th>
            <th>تاریخ ثبت</th>
            <th>وضعیت سفارش</th>
            <th>کد رهگیری پستی</th>
            <th>اقدامات</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td> {{ jdate($order->created_at)->format('%d %B %Y') }} </td>
                <td> {{ $order->status }}</td>
                <td> {{ $order->tracing_serial }} </td>
                <td  class="d-flex">

                </td>
            </tr>
        @endforeach

        </tbody></table>
@endsection
