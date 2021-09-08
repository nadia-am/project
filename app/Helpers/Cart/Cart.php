<?php


namespace App\Helpers\Cart;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Collection;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class Cart
 * @package App\Helpers\Cart
 * @method static Cart put(array $value, $obj = null)
 * @method  static Boolean has( $key)
 * @method  static array get($key, Boolean $withModels)
 * @method  static Collection all()
 * @method  static integer count(array $key)
 * @method  static Cart update($key ,  $option)
 * @method  static Cart delete($key)
 * @method  static Cart flush()
 * @method  static Cart instance()
 * @method  static Void addDiscount(String $code)
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }

}
