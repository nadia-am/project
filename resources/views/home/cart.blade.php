@extends('layouts.app')
@section('script')
    <script>
        function changeQuantity(event, id , cartName = null) {
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type' : 'application/json'
                }
            })
            $.ajax({
                type : 'POST',
                url : '/cart/quantity/change',
                data : JSON.stringify({
                    id : id ,
                    quantity : event.target.value,
                    // cart : cartName,
                    _method : 'patch'
                }),
                success : function(res) {
                    location.reload();
                }
            });
        }

    </script>
@endsection
@section('content')
    <div class="container px-3 my-5 clearfix">
        <!-- Shopping cart table -->
        <div class="card">
            <div class="card-header">
                <h2>سبد خرید</h2>
            </div>
            <div class="card-body">
                @if(count(App\Helpers\Cart\Cart::all()) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered m-0">
                            <thead>
                            <tr>
                                <!-- Set columns width -->
                                <th class="text-center py-3 px-4" style="min-width: 400px;">نام محصول</th>
                                <th class="text-right py-3 px-4" style="width: 150px;">قیمت واحد</th>
                                <th class="text-center py-3 px-4" style="width: 120px;">تعداد</th>
                                <th class="text-right py-3 px-4" style="width: 150px;">قیمت نهایی</th>
                                <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(App\Helpers\Cart\Cart::all() as $cart)
                                @php
                                    $product = $cart['product'];
                                @endphp
                                <tr>
                                    <td class="p-4">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="{{ route('product.single' , $product->id) }}" class="d-block text-dark">{{ $product->title }}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right font-weight-semibold align-middle p-4">
                                        @if($cart['discount_percent'] > 0)
                                            <del class="text-danger text-sm"> {{ $product->price }} تومان</del>
                                            {{ $product->price - ($product->price * $cart['discount_percent'])  }} تومان
                                        @else
                                            {{ $product->price }} تومان
                                        @endif
                                    </td>
                                    <td class="align-middle p-4">
                                        <select onchange="changeQuantity(event, '{{ $cart['id'] }}')" class="form-control text-center">
                                            @for($i=1 ; $i<= $product->inventory ; $i++)
                                                <option value="{{ $i }}" {{ ($cart['quantity'] ==  $i)? "selected":"" }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td class="text-right font-weight-semibold align-middle p-4">
                                        @if($cart['discount_percent'] > 0)
                                            <del class="text-danger text-sm"> {{ $cart['quantity'] * $product->price }} تومان</del>
                                            {{ ( $product->price - ( $product->price * $cart['discount_percent'] ))  * $cart['quantity']  }}
                                            تومان
                                        @else
                                            {{ $cart['quantity'] * $product->price }} تومان
                                        @endif
                                    </td>
                                    <td class="text-center align-middle px-0">
                                        <form action="{{ route('delete.cart',$product->id ) }}" id="delete-cart-{{ $cart['id'] }}" method="post">
                                            @method('delete')
                                            @csrf
                                        </form>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-cart-{{ $cart['id'] }}').submit()" class="shop-tooltip close float-none text-danger" title="" data-original-title="Remove">×</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- / Shopping cart table -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                        <div class="mt-4 ">
                            @php
                                $modals_obj =  \Module::getByStatus(1);
                                $modals = array_keys($modals_obj);
                            @endphp
                            @if(in_array('Discount' , $modals))
                                @if( $discount = \App\Helpers\Cart\Cart::getDiscount() )
                                    <form action="{{ route('discount.remove') }}" method="post" id="removediscount">
                                        @method('delete')
                                        @csrf
                                    </form>
                                    کد تخفیف فعال :
                                    <span class="text-sm text-success"> {{ $discount->code }}</span>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('removediscount').submit()" class="badge badge-danger "> حذف </a>
                                    <div>
                                        درصد تخفیف :
                                        <span class="text-sm text-success"> {{ $discount->percent }}</span>
                                    </div>

                                @else
                                    <form class="mt-4" method="post" action="{{ route('discount.check') }}">
                                        @csrf
                                        <input type="text" name="code" class="form-control"  placeholder="کد تخفیف دارید؟">
                                        <button type="submit" class="btn-sm btn btn-success mt-2 mb-2">اعمال کد تخفیف</button>
                                        @if ($errors->any())
                                            <div class="alert alert-danger small-box ">
                                                {{  $errors->first() }}
                                            </div>
                                        @endif
                                    </form>
                                @endif
                            @endif

                        </div>

                        <div class="d-flex">
                            <div class="text-right mt-4">
                                <label class="text-muted font-weight-normal m-0">قیمت کل</label>
                                @php
                                    $total = \App\Helpers\Cart\Cart::all()->sum(function ($cart) {
                                                    return ($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
                                                });
                                @endphp
                                <div class="text-large"><strong>{{ $total }} تومان</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="float-left">
                    <form action="{{ route('order.payment') }}" method="post" id="cart-payment-order">
                        @csrf
                    </form>
                    <button onclick="document.getElementById('cart-payment-order').submit()" type="button" class="btn btn-lg btn-primary mt-2">پرداخت</button>
                </div>
                @else
                    <div class="text-center text-muted">
                        سبد خرید خالی است
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
