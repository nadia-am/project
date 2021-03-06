<x-admin.content >
    <x-slot name="script">
        <script>
            $('.permissions-list').select2({
                'placeholder' : 'دسترسی ها مورد نظر را انتخاب کنید'
            });
            $('.roles-list').select2({
                'placeholder' : 'نقش ها مورد نظر را انتخاب کنید'
            });
        </script>
    </x-slot>
    <x-slot name="title">
        ایجاد دسترسی جدید
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">لیست کاربران </a></li>
        <li class="breadcrumb-item active">ایجاد دسترسی</li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ایجاد دسترسی</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.users.permissions.store',$user->id) }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="permissions" class="col-sm-2 control-label">نقش ها</label>
                    <select class="form-control roles-list" name="roles[]" id="" multiple>
                        @foreach(\App\Models\Role::all() as $role)
                            <option value="{{ $role->id }}" {{ in_array($role->id , $user->roles->pluck('id')->toArray())  ? 'selected' : ''}} >{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="permissions" class="col-sm-2 control-label">دسترسی ها</label>
                    <select class="form-control permissions-list" name="permissions[]" id="" multiple>
                        @foreach(\App\Models\Permission::all() as $permission)
                            <option value="{{ $permission->id }}"  {{ in_array($permission->id , $user->permissions->pluck('id')->toArray())  ? 'selected' : ''}} >{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ذخیره</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>
