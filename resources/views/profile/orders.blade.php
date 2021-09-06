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
                <td>
                    @switch($order->status)
                        @case( \App\Models\Order::$STATUS_UNPAID)
                            پرداخت نشده
                        @break
                        @case( \App\Models\Order::$STATUS_PAID)
                            پرداخت شده
                        @break

                    @endswitch
                </td>
                <td> {{ $order->tracing_serial ?? 'هنوز ثبت نشده' }} </td>
                <td  class="d-flex">
                    <a href="{{ route('profile.order' , $order->id) }}" class="btn btn-info btn-sm">نمایش سفارش</a>
                    @if(\App\Models\Order::$STATUS_UNPAID == $order->status)
                        <a href="{{ route('profile.order.payment' , $order->id) }}" class="btn btn-warning btn-sm mr-1">پرداخت</a>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody></table>
    {{ $orders->render() }}
@endsection
