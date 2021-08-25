<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class AuthenticateTokenController extends Controller
{
    public function getToken(Request $request)
    {
        if (!$request->session()->has('auth')){
            return redirect(route('login'));
        }
        $request->session()->reflash();
        return view('auth.token');
    }

    public function postToken(Request $request)
    {
        $request->validate([
            'token'=>'required'
        ]);
        if (!$request->session()->has('auth')){
            return redirect(route('login'));
        }
        $user = User::findOrFail($request->session()->get('auth.user_id'));
        $status = ActiveCode::verifyCode($request->token , $user );
        if ($status){
            alert()->error('کد وارد شده صحیح نیست','ورود ناموفق بود');
            return  redirect(route('login'));
        }
        if (auth()->loginUsingId($user->id ,$request->session()->get('auth.remember') )){
            $user->activeCodes()->delete();
            alert()->success('عملیات ورود با موفقیت صورت گرفت','ورود موفق بود');
            return  redirect('/');
        }
        return  redirect(route('login'));
    }
}
