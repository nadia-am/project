@component('admin.layouts.content',['title'=>'لیست کاربران'])
    @slot('breadcrums')
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">لیست دسترسی ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> دسترسی ها</h3>

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
                            @can('create-permissions')
                                <a href="{{ route('admin.permissions.create') }}" class="btn btn-info">ایجاد دسترسی جدید</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی دسترسی</th>
                            <th>نام دسترسی</th>
                            <th>برچسب دسترسی</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td> {{ $permission->name }} </td>
                                <td> {{ $permission->label }}</td>
                                <td  class="d-flex">
                                    @can('edit-permissions')
                                        <a href="{{ route('admin.permissions.edit' , ['permission'=>$permission->id]) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                    @endcan
                                    @can('delete-permissions')
                                        <form action="{{ route('admin.permissions.destroy' , ['permission'=>$permission->id]) }}" method="post" >
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-danger mr-1">حذف</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex">
                    {{ $permissions->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent
