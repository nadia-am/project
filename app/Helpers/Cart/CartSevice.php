<?php


namespace App\Helpers\Cart;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartSevice
{
    protected $cart;

    public function __construct()
    {
        $this->cart = session()->get('cart') ?? collect([]);
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
        session()->put('cart' , $this->cart);

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

    public function update($key , $increament)
    {
        $this->count($key);
        if ($key['product']->inventory < $key['quantity']){
            $item = collect($key);
            $item = $item->merge([
                'quantity' => $item['quantity'] + $increament
            ]);
            $this->put($item->toArray());
        }
        return $this;

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



}
