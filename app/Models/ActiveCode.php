<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    use HasFactory;
    protected $table = 'active_codes';
    protected $fillable = ['user_id','code','expired_at'];
    public $timestamps = false;

    //region relations
    public function user(){
        return $this->belongsTo(User::class);
    }//endregion

    //region scops
    public function scopeGenerateCode($query,$user ){
        if ( $activeCode = $this->getAliveUserCode($user)){
            $code = $activeCode->code;
        }else{
            do{
                $code = mt_rand(100000,999999);
            }while($this->checkCodeIstUniqe($user,$code));
            $user->activeCodes()->create([
                'code'          => $code,
                'expired_at'    => now()->addMinute(10)
            ]);
        }
        return $code;
    }

    public function scopeVerifyCode($query , $token, $user)
    {
        return !! $user->activeCodes()->whereCode($token)->where('expired_at','>',now())->first();
    }
    //endregion

    private function checkCodeIstUniqe( $user ,$code)
    {
        return !! $user->activeCodes()->whereCode($code)->first();
    }

    private function getAliveUserCode($user)
    {
        return $user->activeCodes()->where('expired_at','>',now())->first();
    }

}
