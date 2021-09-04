<?php


namespace App\Helpers\Cart;


use Carbon\Laravel\ServiceProvider;

class CartSeviceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('cart',function (){
            return new CartSevice();
        });
    }

}
