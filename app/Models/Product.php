<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['title','description','price','inventory','viewCount','image'];
    protected $table = "products";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->using(ProductAttributeValue::class)->withPivot('value_id');
    }

    public function scopeFilter($query , $key)
    {
        if ($key){
            $query->where('title','like', "%{$key}%")
                ->orWhere('description','like', "%{$key}%")
                ->orWhere('id','like', "%{$key}%");
        }
    }
}
