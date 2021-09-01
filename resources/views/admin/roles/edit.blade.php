<x-admin.content >
    <x-slot name="title">
        ویرایش نقش
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">لیست اجازه دسترسی ها</a></li>
        <li class="breadcrumb-item active">ویرایش اجازه دسترسی  </li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ویرایش اجازه دسترسی  </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.roles.update' , ['role'=>$role->id]) }}">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام نقش </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="نام نقش  را وارد کنید" value="{{ old('name',$role->name) }}">
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">برچسب نقش </label>
                    <input type="text" class="form-control" name="label" id="label" placeholder="برچسب نقش  را وارد کنید" value="{{ old('label',$role->label) }}">
                </div>
                <div class="form-group">
                    <label for="roles" class="col-sm-2 control-label">دسترسی ها</label>
                    <select class="form-control" name="permissions[]" id="" multiple>
                        @foreach(\App\Models\Permission::all() as $permission)
                            <option value="{{ $permission->id }}" {{ in_array($permission->id , $role->permissions->pluck('id')->toArray())  ? 'selected' : ''}} >
                                {{ $permission->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ویرایش</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</x-admin.content>
