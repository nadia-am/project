<x-admin.content >
    <x-slot name="title">
        ویرایش سفارش
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">لیست سفارش </a></li>
        <li class="breadcrumb-item active">ویرایش سفارش  </li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ویرایش سفارش  </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.orders.update' , ['order'=>$order->id]) }}">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label"> </label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $order->user->name }}" disabled >
                </div>
                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">هزینه سفارش</label>
                    <input type="text" class="form-control" name="price" id="price" value="{{ $order->price }}" disabled >
                </div>
                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">وضعیت سفارش</label>
                    <select name="status" id="" class="form-control">
                        <option value="{{ \App\Models\Order::$STATUS_CANCELED }}" {{ $order->status == \App\Models\Order::$STATUS_CANCELED ? 'selected':'' }} >لغو شده</option>
                        <option value="{{ \App\Models\Order::$STATUS_RECEIVED }}"  {{ $order->status == \App\Models\Order::$STATUS_RECEIVED ? 'selected':'' }}  >دریافت شده</option>
                        <option value="{{ \App\Models\Order::$STATUS_POSTED }}"  {{ $order->status == \App\Models\Order::$STATUS_POSTED ? 'selected':'' }}  >ارسال شده</option>
                        <option value="{{ \App\Models\Order::$STATUS_PREPARATION }}"  {{ $order->status == \App\Models\Order::$STATUS_PREPARATION ? 'selected':'' }}  >در حال آماده سازی</option>
                        <option value="{{ \App\Models\Order::$STATUS_PAID }}"  {{ $order->status == \App\Models\Order::$STATUS_PAID ? 'selected':'' }}  >پرداخت شده</option>
                        <option value="{{ \App\Models\Order::$STATUS_UNPAID }}"  {{ $order->status == \App\Models\Order::$STATUS_UNPAID ? 'selected':'' }}  >پرداخت نشده</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tracing_serial" class="col-sm-2 control-label">شماره پیگیری</label>
                    <input type="text" class="form-control" name="tracing_serial" id="tracing_serial" value="{{ $order->tracing_serial }}"  >
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ویرایش</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>
