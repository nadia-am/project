<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['price','status','tracing_serial'];

    public static $STATUS_UNPAID = "unpaid";
    public static $STATUS_PAID = "paid";
    public static $STATUS_RECEIVED = "received";
    public static $STATUS_CANCELED = "canceled";
    public static $STATUS_POSTED = "posted";
    public static $STATUS_PREPARATION = "preparation";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeFilter($query , $key , $type)
    {
        if ($key ){
            $query->where('id','like',"%{$key}%")->orWhere('tracing_serial','like',"%{$key}%");
        }
         $query->where('status','=',$type);
    }
}
