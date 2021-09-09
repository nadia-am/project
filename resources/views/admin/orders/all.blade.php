<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        لیست سفارشات
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">لیست سفارشات </li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> سفارشات </h3>
                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="hidden" name="type" class="form-control float-right" value="{{ \request('type') }}" >
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>آیدی سفارش</th>
                        <th>نام کاربر</th>
                        <th>هزینه سفارش</th>
                        <th>وضعیت سفارش</th>
                        <th>شماره پیگیری پستی</th>
                        <th>زمان ثبت سفارش</th>
                        <th>اقدامات</th>
                    </tr>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td> {{ $order->price }} </td>
                            <td>
                                @switch($order->status)
                                    @case( \App\Models\Order::$STATUS_UNPAID)
                                        پرداخت نشده
                                        @break
                                    @case( \App\Models\Order::$STATUS_PAID)
                                        پرداخت شده
                                        @break
                                    @case( \App\Models\Order::$STATUS_CANCELED)
                                        لغو شده
                                        @break
                                    @case( \App\Models\Order::$STATUS_RECEIVED)
                                        دریافت شده
                                        @break
                                    @case( \App\Models\Order::$STATUS_POSTED)
                                        ارسال شده
                                        @break
                                    @case( \App\Models\Order::$STATUS_PREPARATION)
                                        در حال آماده سازی
                                        @break

                                @endswitch
                            </td>
                            <td> {{ $order->tracing_serial ?? 'ثبت نشده' }} </td>
                            <td> {{ jdate($order->created_at)->ago() }} </td>
                            <td  class="d-flex">
                                @can('show-orders')
                                    <a href="{{ route('admin.orders.show' , ['order'=>$order->id]) }}" class="btn btn-sm btn-default">مشاهده جزئیات سفارش</a>
                                    <a href="{{ route('admin.order.show.payments' , ['order'=>$order->id]) }}" class="btn btn-sm btn-info mr-1">مشاهده پرداخت ها</a>
                                @endcan
                                @can('edit-orders')
                                    <a href="{{ route('admin.orders.edit' , ['order'=>$order->id]) }}" class="btn btn-sm btn-primary mr-1">ویرایش سفارش</a>
                                @endcan
                                @can('delete-orders')
                                    <form action="{{ route('admin.orders.destroy' , ['order'=>$order->id]) }}" method="post" >
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger mr-1">حذف</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex">
                    {{ $orders->appends(['type'=>request('type'),'search'=>request('search')])->render()  }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
