<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        ایجاد کاربر جدید
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">ایجاد کاربر جدید</li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ایجاد کاربر جدید</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام کاربری</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="نام کاربری را وارد کنید">
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">ایمیل</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="ایمیل را وارد کنید">
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">پسورد</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="پسورد را وارد کنید">
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="col-sm-2 control-label">تکرار پسورد</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password-confirm" placeholder="تکرار پسورد را وارد کنید">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="confirm_email" id="confirm_email">
                    <label for="confirm_email" class="col-sm-2 control-label">تایید ایمیل</label>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ثبت</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>
