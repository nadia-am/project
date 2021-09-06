<x-admin.content >
    <x-slot name="title">
        ایجاد محصول جدید
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ایجاد محصول جدید</li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ایجاد محصول جدید</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">عنوان</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان محصول را وارد کنید" value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">توضیحات</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">قیمت</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="قیمت محصول را وارد کنید" value="{{ old('price') }}">
                </div>
                <div class="form-group">
                    <label for="inventory" class="col-sm-2 control-label">تعداد موجودی محصول</label>
                    <input type="number" class="form-control" name="inventory" id="inventory" placeholder="تعداد موجودی محصول را وارد کنید" value="{{ old('inventory') }}">
                </div>
                <div class="form-group">
                    <label for="image" class="col-sm-2 control-label">تصویر محصول</label>
{{--                    <input type="file" class="form-control" name="image" id="image" >--}}
                    <div class="input-group">
                        <input type="text" id="image_label" class="form-control" name="image"
                               aria-label="Image" aria-describedby="button-image">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="button-image">Select</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inventory" class="col-sm-2 control-label">دسته بندی </label>
                    <select name="categories[]" class="form-control" id="categories" multiple>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}"  >
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ایجاد محصول</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>
