<?php

namespace App\Http\Controllers\Admin\users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    public function create(User $user)
    {
        return view('admin.users.permissions' , compact('user'));
    }

    public function store(Request $request , User $user)
    {
        $user->permissions()->sync( $request->permissions );
        $user->roles()->sync( $request->roles );
        alert()->success('عملیات با موفقیت انجام گرفت', 'عملیات موفق');
        return redirect(route('admin.users.index'));
    }
}
