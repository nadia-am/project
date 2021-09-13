<?php


namespace App\Helpers\Cart;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Modules\Discount\Entities\Discount;

class CartService
{
    protected $cart;
    private $name = "my-cart";

    public function __construct()
    {
        $cart = collect(json_decode( Cookie::get($this->name) , true));
        $this->cart = $cart->count() ? $cart : collect([
            'items'=>[],
            'discount'=>null,
        ]);
    }
    public function instance()
    {
        $cart = collect(json_decode(request()->cookie($this->name) , true));
        $this->cart = $cart->count() ? $cart : collect([
            'items' => [],
            'discount' => null
        ]);
        return $this;
    }

    public function put(array $value, $obj = null)
    {
        if (! is_null($obj) || $obj instanceof Model){
            $value = array_merge($value , [
                'id'=> Str::random(10),
                'subject_id'=> $obj->id ,
                'subject_type'=> get_class($obj),
                'discount_percent'=> 0,
            ]);
        }elseif (! isset($value['id'])){
            $value = array_merge($value , [
                'id'=> Str::random(10),
            ]);
        }

        $this->cart['items'] = collect($this->cart['items'])->put($value['id'] , $value);
        $this->saveCookie();
        return $this;
    }

    public function has( $key)
    {
        if ($key instanceof Model){
            return ! is_null(
                collect($this->cart['items'])->where('subject_id',$key->id) ->where('subject_type',get_class($key))->first()
            );
        }
        return ! is_null(collect($this->cart['items'])->firstWhere('id',$key));
    }

    public function get($key , $withModels = true)
    {
        $item = $key instanceof Model ?
            collect($this->cart['items'])->where('subject_id',$key->id) ->where('subject_type',get_class($key))->first() :
            collect($this->cart['items'])->firstWhere('id',$key);
        return $withModels? $this->AddModelIfExist($item) : $item;

    }

    public function all()
    {
        $cart = $this->cart;

        $cart = collect($this->cart['items'])->map(function($item) use ($cart) {
            $item = $this->AddModelIfExist($item);
            $item = $this->checkDiscountValidate($item , $cart['discount']);
            return $item;
        });
        return $cart;
    }

    public function update($key , $option)
    {
        $list = Cart::get($key,false);
        $item = collect($list);
        if (is_numeric($option)){
            $item = $item->merge([
                'quantity' => $item['quantity'] + $option
            ]);
        }
        if (is_array($option)){
            $item = $item->merge($option);
        }
        $this->put($item->toArray());
        return $this;

    }

    public function delete($key)
    {
        if ($this->has($key)){
            if ($key instanceof Model){
                $list = $this->get($key);
                $key = $list['id'];
            }
            $this->cart['items'] = collect($this->cart['items'])->forget($key);
            $this->saveCookie();
            return true;
        }
        return false;
    }

    public function flush()
    {
        $this->cart = collect([
            'items'=>[],
            'discount'=>null,
        ]);
        $this->saveCookie();
    }

    public function addDiscount($code)
    {
        $this->cart['discount'] = $code;
        $this->saveCookie();
    }

    public function getDiscount(){
        $discount = Discount::where('code', $this->cart['discount'] )->first();
        return $discount;
    }

    protected function AddModelIfExist($item)
    {
        if ( isset($item['subject_id']) && isset($item['subject_type']) ){
            $class = $item['subject_type'];
            $subject = ( new $class())->find($item['subject_id']);
            $item[strtolower(class_basename($item['subject_type']))] = $subject;
            unset($item['subject_id']);
            unset($item['subject_type']);
        }
        return $item;
    }

    protected function saveCookie()
    {
        Cookie::queue($this->name, $this->cart->toJson(),( 60*24) * 2);
    }

    protected function checkDiscountValidate($item, $code)
    {
        $discount = Discount::where('code',$code)->first();

        if ( $discount && $discount->expired_at > now() ){
            if (
                (!$discount->products()->count() && !$discount->categories()->count()) ||
                ( in_array($item['product']->id , $discount->products()->pluck('id')->toArray() ) ) ||
                ( array_intersect( $discount->products()->pluck('id')->toArray() , $item['product']->categories()->pluck('id')->toArray() ) )
                  ){
                $item['discount_percent'] = $discount->percent / 100;
            }
        }
        return $item;
    }


}
