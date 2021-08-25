<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('email' , $google_user->email )->first();
            if ($user){
                auth()->loginUsingId($user->id);
            }
            else{
                $created_user = User::create([
                    'name'=>$google_user->name,
                    'email'=>$google_user->email,
                    'password'=>bcrypt(Str::random(6)),
                ]);
                auth()->loginUsingId($created_user->id);
            }
            return redirect('/');
        }catch (\Exception $e){
            Log::error('Error Login with google : ' . $e);
            alert()->error('ورود با گوگل موفق نبود', 'خطا دارید')->persistent('خب');
            return redirect('/login');
        }
    }
}
