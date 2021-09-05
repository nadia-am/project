<?php


namespace App\Helpers\Cart;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartSevice
{
    protected $cart;
    private $name = "my-cart";

    public function __construct()
    {
//        $this->cart = session()->get($this->name) ?? collect([]);
        $value = json_decode( Cookie::get($this->name) , true);
        $this->cart = collect($value) ?? collect([]);
    }

    public function put(array $value, $obj = null)
    {
        if (! is_null($obj) || $obj instanceof Model){
            $value = array_merge($value , [
                'id'=> Str::random(10),
                'subject_id'=> $obj->id ,
                'subject_type'=> get_class($obj),
            ]);
        }elseif (! isset($value['id'])){
            $value = array_merge($value , [
                'id'=> Str::random(10),
            ]);
        }
        $this->cart->put($value['id'] , $value);
//        session()->put($this->name , $this->cart);
        $this->saveCookie();

        return $this;
    }

    public function has( $key)
    {
        if ($key instanceof Model){
            return ! is_null(
                $this->cart->where('subject_id',$key->id) ->where('subject_type',get_class($key))->first()
            );
        }
        return ! is_null($this->cart->firstWhere('id',$key));
    }

    public function get($key , $withModels = true)
    {
        $item = $key instanceof Model ?
            $this->cart->where('subject_id',$key->id) ->where('subject_type',get_class($key))->first() :
            $this->cart->firstWhere('id',$key);
        return $withModels? $this->AddModelIfExist($item) : $item;

    }

    public function all()
    {
        $items = $this->cart ;
        $items = $items->map(function ($item){
            return $this->AddModelIfExist($item);
        });
        return $items;
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
            $this->cart = $this->cart->forget($key);
//            session()->put('cart' , $this->cart);
            $this->saveCookie();
            return true;
        }
        return false;
    }

    public function flush()
    {
        $this->cart = collect([]);
        $this->saveCookie();
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


}
