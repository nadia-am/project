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

if (!function_exists('sort_comments')) {
    function sort_comments($comments , $parent_id = 0)
    {
        $result =[];
        foreach ($comments as $comment){
            if ($comment->parent_id == $parent_id ){
                $data = $comment->toArray();
                $data['user'] = $comment->user;
                $data['childeren'] = sort_comments($comments , $comment->id );
                $result[] = $data;
            }
        }
        return $result;
    }
}
