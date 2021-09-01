<x-admin.content >
    <x-slot name="title">
        لیست نقش ها
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">لیست نقش ها</li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> نقش ها</h3>

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
                            @can('create-roles')
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-info">ایجاد نقش جدید</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی نقش</th>
                            <th>نام نقش</th>
                            <th>برچسب نقش</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td> {{ $role->name }} </td>
                                <td> {{ $role->label }}</td>
                                <td  class="d-flex">
                                    @can('edit-roles')
                                        <a href="{{ route('admin.roles.edit' , ['role'=>$role->id]) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                    @endcan

                                    @can('delete-roles')
                                        <form action="{{ route('admin.roles.destroy' , ['role'=>$role->id]) }}" method="post" >
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
                    {{ $roles->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
