<x-admin.content>
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        لیست دسته بندی ها
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="/">خانه</a></li>
        <li class="breadcrumb-item active">لیست دسته بندی ها </li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">دسته بندی</h3>

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
                            @can('create-categories')
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-info">ایجاد دسته جدید</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    @include('layouts.category-group', ['categories' => $categories])
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex">
                    {{ $categories->appends(['search'=>request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
