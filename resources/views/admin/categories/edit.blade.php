<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        ویرایش دسته
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">ویرایش دسته جدید</li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ویرایش دسته جدید</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.categories.update' , ['category'=>$category->id]) }}">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="نام کاربری را وارد کنید" value="{{ old('name' , $category->name) }}">
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label" >والد </label>
                    <select name="parent_id" class="form-control" id="parent_id">
                        <option value="0" {{ (old('parent_id' , $category->parent_id) == 0 )? 'selected':'' }} >بدون والد</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            @if($cat->parent_id != 0)
                                @php
                                    $parent = \App\Models\Category::find($cat->parent_id);
                                @endphp
                            @endif
                            <option value="{{ $cat->id }}" {{ (old('parent_id' , $category->parent_id) == $cat->id )? 'selected':'' }}>
                                {{ ($cat->parent_id != 0) ? $parent->name." - " :"" }}  {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ویرایش</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>
