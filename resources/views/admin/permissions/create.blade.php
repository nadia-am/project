<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">ایجاد دسترسی جدید </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">لیست دسترسی </a></li>
        <li class="breadcrumb-item active">ایجاد دسترسی جدید</li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ایجاد دسترسی جدید</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.permissions.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام دسترسی </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="نام دسترسی  را وارد کنید" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">برچسب دسترسی </label>
                    <input type="text" class="form-control" name="label" id="label" placeholder="برچسب دسترسی  را وارد کنید" value="{{ old('label') }}">
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ذخیره</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</x-admin.content>
