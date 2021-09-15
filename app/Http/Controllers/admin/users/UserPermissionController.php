<?php

namespace App\Http\Controllers\admin\users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserPermissionController extends Controller
{
    public function create(User $user)
    {
        return view('admin.users.permissions' , compact('user'));
    }

    public function store(Request $request , User $user)
    {
        try {
            DB::beginTransaction();
            $user->permissions()->sync( $request->permissions );
            $user->roles()->sync( $request->roles );
            alert()->success('عملیات با موفقیت انجام گرفت', 'عملیات موفق');
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }

        return redirect(route('admin.users.index'));
    }
}
