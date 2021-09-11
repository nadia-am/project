<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        لیست سفارشات
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="/">خانه</a></li>
        <li class="breadcrumb-item "><a href="{{ route('admin.orders.index') }}">لیست سفارشات</a> </li>
        <li class="breadcrumb-item active">
            جزئیات سفارش
            {{ $order->id }}
        </li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        جزئیات سفارش
                        {{ $order->id }}
                    </h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>آیدی محصول</th>
                        <th>نام کاربر</th>
                        <th>نام محصول</th>
                        <th>تعداد</th>
                    </tr>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->user->name }}</td>
                            <td> {{ $product->title }} </td>
                            <td> {{ $product->pivot->quantity }} </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex">
                    {{ $products->render()  }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
