<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $table = 'attributes';
    protected $fillable = ['name'];

    public function Values()
    {
        return $this->hasMany(AttributeValues::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
