<x-admin.content >
    <x-slot name="script">
        <script>
            $('.user-list').select2({
                'placeholder' : 'کاربر مورد نظر را انتخاب کنید'
            });
            $('.product-list').select2({
                'placeholder' : 'محصولات مورد نظر را انتخاب کنید'
            });
            $('.category-list').select2({
                'placeholder' : 'دسته بندی مورد نظر را انتخاب کنید'
            });

        </script>
    </x-slot>
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
                    <label for="users" class="col-sm-2 control-label ">کاربر مورد نظر را انتخاب کنید (اختیاری) </label>
                    <select name="users[]" class="form-control user-list" id="users" multiple>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}"  {{ in_array($user->id,$discount->users()->pluck('id')->toArray())? 'selected':'' }}  >
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="products" class="col-sm-2 control-label ">مجصولات </label>
                    <select name="products[]" class="form-control product-list" id="products" multiple>
                        @foreach(\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}" {{ in_array($product->title,$discount->products()->pluck('title')->toArray())? 'selected':'' }} >
                                {{ $product->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="categories" class="col-sm-2 control-label ">دسته بندی </label>
                    <select name="categories[]" class="form-control category-list" id="categories" multiple>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" {{ in_array($cat->name,$discount->categories()->pluck('name')->toArray())? 'selected':'' }}  >
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="expired_at" class="col-sm-2 control-label">زمان انقضای کد تخفیف</label>
                    <input type="date" class="form-control" name="expired_at" id="expired_at"  value="{{ old('expired_at', $discount->expired_at) }}">
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
