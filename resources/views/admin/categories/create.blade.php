<x-admin.content >
    <x-slot name="title">
        ایجاد دسته جدید
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">ایجاد دسته جدید</li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ایجاد دسته جدید</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="نام کاربری را وارد کنید" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label" >والد </label>
                    <select name="parent_id" class="form-control" id="parent_id">
                        <option value="0">بدون والد</option>
                        @foreach(\App\Models\Category::all() as $category)
                            @if($category->parent_id != 0)
                                @php
                                    $parent = \App\Models\Category::find($category->parent_id);
                                @endphp
                            @endif
                            <option value="{{ $category->id }}"> {{ ($category->parent_id != 0)?$parent->name." - " :"" }}  {{ $category->name }} </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ثبت</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>
