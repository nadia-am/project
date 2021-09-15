<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = ['name','label'];
    public $timestamps = false;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeFilter($query , $key)
    {
        if ($key ){
            $query->where('label','like', "%{$key}%")
                ->orWhere('name','like', "%{$key}%")
                ->orWhere('id','like', "%{$key}%");
        }
    }
}
