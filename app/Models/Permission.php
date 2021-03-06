<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = ['name','label'];
    public $timestamps= false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeFilter($query ,$key )
    {
        if ($key ){
            $permissions = $query->where('name','like', "%{$key}%")
                ->orWhere('label','like', "%{$key}%")
                ->orWhere('id','like', "%{$key}%");
        }
    }
}
