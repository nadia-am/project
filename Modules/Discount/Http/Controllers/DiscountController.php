<?php

namespace Modules\Discount\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Routing\Controller;
use Modules\Discount\Entities\Discount;
use Modules\Discount\Http\Requests\checkDiscountRequest;

class DiscountController extends Controller
{
    public function check(checkDiscountRequest $request)
    {
        $discount = Discount::whereCode($request->code)->first();

        if (! auth()->check()){
            return back()->withErrors([
                'discount'=>'برای استفاده از کد تخفیف ابتدا ورود کنید'
            ]);
        }

        if ($discount->expired_at < now()){
            return back()->withErrors([
                'discount'=>'مهلت استفاده از کد تخفیف به پایان رسید'
            ]);
        }

        if ($discount->users()->count()){
            if ( ! in_array( auth()->user()->id , $discount->users()->pluck('id')->toArray() )){
                return back()->withErrors([
                    'discount'=>'شما مجاز به استفاده از این کد تخفیف نیستید'
                ]);
            }
        }

        Cart::addDiscount($discount->code);
        return back();

    }
}
