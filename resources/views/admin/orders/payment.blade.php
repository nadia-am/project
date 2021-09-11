<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        لیست پرداخت ها
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="/">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">لیست سفارش </a></li>
        <li class="breadcrumb-item active">لیست پرداخت ها </li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> پرداخت ها </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>آیدی پرداخت</th>
                        <th>نام کاربر</th>
                        <th>وضعیت سفارش</th>
                        <th>شماره پرداخت </th>
                        <th>زمان ثبت پرداخت</th>
                    </tr>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>
                                @if($payment->status)
                                    پرداخت شده
                                @else
                                    پرداخت نشده
                                @endif
                            </td>
                            <td> {{ $payment->resnumber  }} </td>
                            <td> {{ jdate($payment->created_at)->ago() }} </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex">
{{ $payments->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
