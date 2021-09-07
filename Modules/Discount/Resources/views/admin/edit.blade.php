<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        ویرایش کد تخفیف جدید
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="/admin">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.discount.index') }}">لیست کد تخفیف</a></li>
        <li class="breadcrumb-item active">ویرایش کد تخفیف جدید</li>
    </x-slot>

    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">ویرایش کد تخفیف جدید</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layouts.error')
        <form class="form-horizontal" method="post" action="{{ route('admin.discount.update', $discount->id) }}" >
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="code" class="col-sm-2 control-label">کد تخفیف</label>
                    <input type="text" class="form-control" name="code" id="code" placeholder="کد تخفیف را وارد کنید" value="{{ old('code', $discount->code) }}">
                </div>
                <div class="form-group">
                    <label for="percent" class="col-sm-2 control-label">درصد تخفیف</label>
                    <input type="number" class="form-control" name="percent" id="percent" placeholder="درصد تخفیف را وارد کنید" value="{{ old('percent', $discount->percent) }}">
                </div>
                <div class="form-group">
                    <label for="users" class="col-sm-2 control-label">کاربران </label>
                    <select name="users[]" class="form-control" id="users" multiple>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->email }}"  {{ in_array( $user->email, json_decode($discount->user)) ? 'selected': '' }}>
                                {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="products" class="col-sm-2 control-label">مجصولات </label>
                    <select name="products[]" class="form-control" id="products" multiple>
                        @foreach(\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}" {{ in_array($product->title,$discount->products()->pluck('title')->toArray())? 'selected':'' }} >
                                {{ $product->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="categories" class="col-sm-2 control-label">دسته بندی </label>
                    <select name="categories[]" class="form-control" id="categories" multiple>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" {{ in_array($cat->name,$discount->categories()->pluck('name')->toArray())? 'selected':'' }}  >
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">ویرایش </button>
                <a href="{{ route('admin.discount.index') }}" class="btn btn-default float-left">لغو</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</x-admin.content>