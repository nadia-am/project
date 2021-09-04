<?php

namespace App\Http\Controllers;

use App\Http\Requests\comment\SendCommentRequest;
use App\Http\Requests\profile\getTokenverifyEmailRequest;
use App\Http\Requests\profile\manageTwoFactorPostRequest;
use App\Models\ActiveCode;
use App\Models\Comment;
use App\Notifications\sendEmailInLogInNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function manageTwoFactor()
    {
        return view('profile.two-factor-auth');
    }

    public function manageTwoFactorPost(manageTwoFactorPostRequest $request)
    {
        if ($this->isRequestTypeSms($request)){
            if ($request->phone !== auth()->user()->phone_number){
                return $this->createCodeAndSendSms($request);
            }else{
                $request->user()->update([
                    'two_factor_auth'=>'sms',
                ]);
            }
        }

        if ($this->isRequestTypeOff($request)){
            $request->user()->update([
                'two_factor_auth'=>'off',
            ]);
        }
        return back();
    }

    public function getPhoneVerify(Request $request)
    {
        if ( !$request->session()->has('phone') ) return redirect(route('profile.2fa'));
        $request->session()->reflash();
        return view('profile.phone-verify');
    }

    public function postPhoneVerify(getTokenverifyEmailRequest $request)
    {
        if ( !$request->session()->has('phone') ) return redirect(route('profile.2fa'));
        $status = ActiveCode::verifyCode($request->token , $request->user() );
        if ($status){
            $request->user()->activeCodes()->delete();
            $user = $request->user()->update([
                'two_factor_auth'=>'sms',
                'phone_number' => $request->session()->get('phone')
            ]);
            alert()->success('شماره تلفن و احراز هویت دومرحله ای شما انجام شد.', 'عملیات موفقیت آمیز بود');
        }else{
            alert()->error('شماره تلفن و احراز هویت دومرحله ای شما انجام نشد.', 'عملیات نا موفق بود');
        }

        return redirect(route('profile.2fa'));
    }

    /**
     * @param manageTwoFactorPostRequest $request
     * @return bool
     */
    public function isRequestTypeSms(manageTwoFactorPostRequest $request)
    {
        return $request->type == 'sms';
    }

    /**
     * @param manageTwoFactorPostRequest $request
     * @return bool
     */
    public function isRequestTypeOff(manageTwoFactorPostRequest $request)
    {
        return $request->type == 'off';
    }

    /**
     * @param manageTwoFactorPostRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createCodeAndSendSms(manageTwoFactorPostRequest $request)
    {
        $code = ActiveCode::generateCode($request->user());
        $request->session()->flash('phone', $request->phone);
        //TODO 1. Send code to user new phone
        $request->user()->notify(new sendEmailInLogInNotification($code));
        Log::info('Active code :' . $code);
        return redirect(route('phone.verify'));
    }

    public function sendComment(SendCommentRequest $request)
    {
//        if ( ! $request->ajax() ){
//            return response()->json([
//                'status'=>'failed',
//                'message'=>'just ajax available'
//            ]);
//        }
        auth()->user()->comments()->create([
            'comment'=>$request->comment,
            'parent_id'=>$request->parent_id,
            'commentable_id'=>$request->commentable_id,
            'commentable_type'=>$request->commentable_type,
        ]);
        alert()->success('افزودن با موفقیت انجام گرفت', 'عملیات موفق');
        return back();
//        return response()->json([
//            'status'=>'success'
//        ]);
    }


}
