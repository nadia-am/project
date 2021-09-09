<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        لیست تخفیفات
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">لیست تخفیفات</li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تخفیفات</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group-sm mr-2">
                            @can('create-discounts')
                                <a href="{{ route('admin.discount.create') }}" class="btn btn-info">ایجاد کد تخفیف جدید</a>
                            @endcan

                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی</th>
                            <th>کد تخفیف</th>
                            <th>میزان تخفیف</th>
                            <th>مربوط به کاربر</th>
                            <th>مربوط به محصول</th>
                            <th>مربوط به دسته</th>
                            <th>زمان انقضای کد</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($discounts as $discount)
                            <tr>
                                <td>{{ $discount->id }}</td>
                                <td> {{ $discount->code }} </td>
                                <td> {{ $discount->percent }}</td>

                                <td> {{ $discount->users->count() ? $discount->users->pluck('name')->join(', ') : 'همه کاربران' }} </td>
                                <td> {{ $discount->products->count() ? $discount->products->pluck('title')->join(', ') : 'همه محصولات' }} </td>
                                <td> {{ $discount->categories->count() ? $discount->categories->pluck('name')->join(', ') : 'همه دسته ها' }} </td>
                                <td> {{ jdate($discount->expired_at)->ago() }} </td>
                                <td  class="d-flex">
                                    @can('edit-discounts')
                                        <a href="{{ route('admin.discount.edit' , ['discount'=>$discount->id]) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>
                                    @endcan

                                    @can('delete-discounts')
                                        <form action="{{ route('admin.discount.destroy' , ['discount'=>$discount->id]) }}" method="post" >
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-danger mr-1">حذف</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach

                        </tbody></table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex">
                    {{ $discounts->appends(['search'=>request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
