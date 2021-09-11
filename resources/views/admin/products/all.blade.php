<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        لیست محصولات
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="/">خانه</a></li>
        <li class="breadcrumb-item active">لیست محصولات</li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">محصولات</h3>

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
                            @can('create-products')
                                <a href="{{ route('admin.products.create') }}" class="btn btn-info">ایجاد محصول جدید</a>
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
                            <th>عنوان</th>
                            <th>توضیحات</th>
                            <th>قیمت</th>
                            <th>تعداد موجودی</th>
                            <th>تعداد بازدید</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td> {{ $product->title }} </td>
                                <td> {{ $product->description }}</td>
                                <td> {{ $product->price }} </td>
                                <td> {{ $product->inventory }} </td>
                                <td> {{ $product->viewCount }} </td>
                                <td  class="d-flex">
                                    @can('edit-products')
                                        <a href="{{ route('admin.products.edit' , ['product'=>$product->id]) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>
                                    @endcan

                                    @can('delete-products')
                                        <form action="{{ route('admin.products.destroy' , ['product'=>$product->id]) }}" method="post" >
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-danger mr-1">حذف</button>
                                        </form>
                                    @endcan
                                    <a href="{{ route('admin.products.galleries.index' , ['product'=>$product->id]) }}" class="btn btn-sm btn-warning mr-1">گالری تصاویر</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody></table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex">
                    {{ $products->appends(['search'=>request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
