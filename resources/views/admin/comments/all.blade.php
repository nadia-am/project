<x-admin.content >
    <x-slot name="title">
        لیست نظرات
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">لیست نظرات</li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">نظرات</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                     </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی نظر</th>
                            <th>نام کاربر</th>
                            <th>دیدگاه</th>
                            <th>وضعیت</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td> {{ $comment->user->name }} </td>
                                <td> {{ $comment->comment }}</td>
                                <td>
                                    @if($comment->approved)
                                        <span class="badge badge-success">تایید شده</span>
                                    @else
                                        <span class="badge badge-warning">تایید نشده</span>
                                    @endif

                                </td>
                                <td  class="d-flex">

                                    @can('edit-comment')
                                        <form action="{{ route('admin.comments.update' , ['comment'=>$comment->id]) }}" method="post" >
                                            @method('put')
                                            @csrf
                                            <button class="btn btn-sm btn-success mr-1">تایید</button>
                                        </form>
                                    @endcan

                                    @can('delete-comment')
                                        <form action="{{ route('admin.comments.destroy' , ['comment'=>$comment->id]) }}" method="post" >
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
                    {{ $comments->appends(['search'=>request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
