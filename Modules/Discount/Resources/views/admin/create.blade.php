<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        ایجاد کد تخفیف جدید
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.discount.index') }}">لیست کد تخفیف</a></li>
        <li class="breadcrumb-item active">ایجاد کد تخفیف جدید</li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ایجاد کد تخفیف جدید</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.discount.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="code" class="col-sm-2 control-label">کد تخفیف</label>
                    <input type="text" class="form-control" name="code" id="code" placeholder="کد تخفیف را وارد کنید" value="{{ old('code') }}">
                </div>
                <div class="form-group">
                    <label for="percent" class="col-sm-2 control-label">درصد تخفیف</label>
                    <input type="number" class="form-control" name="percent" id="percent" placeholder="درصد تخفیف را وارد کنید" value="{{ old('percent') }}">
                </div>
                <div class="form-group">
                    <label for="users" class="col-sm-2 control-label">کاربر مورد نظر را انتخاب کنید (اختیاری) </label>
                    <select name="users[]" class="form-control" id="users" multiple>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}"  >
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="products" class="col-sm-2 control-label">مجصولات </label>
                    <select name="products[]" class="form-control" id="products" multiple>
                        @foreach(\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}"  >
                                {{ $product->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="categories" class="col-sm-2 control-label">دسته بندی </label>
                    <select name="categories[]" class="form-control" id="categories" multiple>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}"  >
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="expired_at" class="col-sm-2 control-label">زمان انقضای کد تخفیف</label>
                <input type="date" class="form-control" name="expired_at" id="expired_at"  value="{{ old('expired_at') }}">
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ایجاد </button>
                <a href="{{ route('admin.discount.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>
