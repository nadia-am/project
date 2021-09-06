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

if (! function_exists('isUrl')){
    function isUrl($routeNmae , $class = 'active'){
        if (is_array($routeNmae)){
            return in_array( url()->full() , $routeNmae) ? $class: '';
        }
        return url()->full()== $routeNmae? $class: '';
    }
}


