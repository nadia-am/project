<?php


namespace App\Http\Controllers\Auth;


use App\Models\ActiveCode;
use Illuminate\Http\Request;

trait TwoFactorAuthenticate
{
    public function loggedIn(Request $request, $user)
    {
        if ($user->has2factorAuth()){
            auth()->logout();
            $code = ActiveCode::generateCode($user);
            $request->session()->flash('auth',[
                'user_id'=>$user->id,
                'using_sms'=> true,
                'remember'=>$request->has('remember'),
            ]);
            //TODO send sms
            return redirect(route('2fa.token'));
        }
        return false;

    }

}
