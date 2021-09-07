<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        ویرایش اجازه دسترسی
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">لیست اجازه دسترسی ها</a></li>
        <li class="breadcrumb-item active">ویرایش اجازه دسترسی  </li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ویرایش اجازه دسترسی  </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.permissions.update' , ['permission'=>$permission->id]) }}">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام اجازه دسترسی ی</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="نام اجازه دسترسی را وارد کنید" value="{{ old('name', $permission->name) }}">
                </div>
                <div class="form-group">
                    <label for="label" class="col-sm-2 control-label">برچسب اجازه دسترسی ی</label>
                    <input type="text" class="form-control" name="label" id="label" placeholder="برچسب اجازه دسترسی را وارد کنید" value="{{ old('label',$permission->label) }}">
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ویرایش</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>
