<?php


namespace App\Http\Controllers\Auth;


use App\Models\ActiveCode;
use App\Notifications\sendEmailInLogInNotification;
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
            $user->notify(new sendEmailInLogInNotification($code));
            return redirect(route('2fa.token'));
        }

        return false;
    }

}
