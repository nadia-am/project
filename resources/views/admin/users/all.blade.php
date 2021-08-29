@component('admin.layouts.content',['title'=>'لیست کاربران'])
    @slot('breadcrums')
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">لیست کاربران</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">کاربران</h3>

                    <div class="card-tools d-flex">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="جستجو">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="btn-group-sm mr-2">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-info">ایجاد کاربر جدید</a>
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
                                <td>
                                    <a href="{{ route('admin.users.edit' , ['user'=>$user->id]) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                    <a href="#" class="btn btn-sm btn-danger">حذف</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody></table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent
