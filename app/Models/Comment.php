<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $fillable = ['comment','approved','parent_id','commentable_id','commentable_type'];

    //region relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function commentable()
    {
        return $this->morphTo();
    }

    public function childeren()
    {
        return $this->hasMany(Comment::class , 'parent_id','id');
    }
    //endregion relation

    //region scope
    public function scopeFilter($query , $key)
    {
        if ($key){
            $comments = $query->where('comment','like',"%{$key}%")
                ->orWhereHas('user', function ($query) use ($key){
                    $query->where('name', 'like',"%{$key}%");
                });
        }
    }
    //endregion scope




}
