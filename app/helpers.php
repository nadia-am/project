<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

if (! function_exists('isActive')){
    function isActive($routeNmae , $class = 'active'){
        if (is_array($routeNmae)){
            return in_array(Route::currentRouteName() , $routeNmae) ? $class: '';
        }
        return Route::currentRouteName()== $routeNmae? $class: '';
    }
}


