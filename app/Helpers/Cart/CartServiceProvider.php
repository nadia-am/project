<?php


namespace App\Helpers\Cart;


use Carbon\Laravel\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        // it means fire CardService whenever 'cart' were called
        $this->app->singleton('cart',function (){
            return new CartService();
        });
    }

}
