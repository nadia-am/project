<x-admin.content >
    <x-slot name="title">
        لیست کاربران
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">لیست کاربران</li>
    </x-slot>>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">کاربران</h3>

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
                            @can('create-user')
                                <a href="{{ route('admin.users.create') }}" class="btn btn-info">ایجاد کاربر جدید</a>
                            @endcan
                            @can('show-staff-user')
                                <a href="{{ request()->fullUrlWithQuery(['admin'=>1]) }}" class="btn btn-warning">نمایش کاربران ادمین</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی کاربر</th>
                            <th>نام کاربر</th>
                            <th>ایمیل کاربر</th>
                            <th>وضعیت ایمیل</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td> {{ $user->name }} </td>
                                <td> {{ $user->email }}</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge badge-success">تایید شده</span>
                                    @else
                                        <span class="badge badge-danger">تایید نشده</span>
                                    @endif

                                </td>
                                <td  class="d-flex">
                                    @if(auth()->user()->isSuperUser())
                                        @can('stafff-users-permission')
                                            <a href="{{ route('admin.users.permissions',$user->id) }}" class="btn btn-sm btn-info">دسترسی ها</a>
                                        @endcan
                                    @endif

                                    @can('edit-user')
                                        <a href="{{ route('admin.users.edit' , ['user'=>$user->id]) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>
                                    @endcan

                                    @can('delete-user')
                                        <form action="{{ route('admin.users.destroy' , ['user'=>$user->id]) }}" method="post" >
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
                    {{ $users->appends(['search'=>request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>