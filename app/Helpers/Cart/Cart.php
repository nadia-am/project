<?php


namespace App\Helpers\Cart;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Collection;

/**
 * Class Cart
 * @package App\Helpers\Cart
 * @method static Cart put(array $value, $obj = null)
 * @method  static Boolean has( $key)
 * @method  static array get($key)
 * @method  static Collection all()
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }

}
