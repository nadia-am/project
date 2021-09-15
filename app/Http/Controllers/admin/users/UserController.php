<?php

namespace App\Http\Controllers\Admin\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CreateAdminUserRequest;
use App\Http\Requests\admin\UpdateAdminUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-users')->only(['index']);
        $this->middleware('can:create-users')->only(['create','store']);
        $this->middleware('can:edit-users')->only(['edit' , 'update']);
        $this->middleware('can:delete-users')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->filter(request('search') , request('admin'))->paginate(10);
        return view('admin.users.all' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdminUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,
            ]);
            if ($request->has('confirm_email')){
                $user->markEmailAsVerified();
            }
            alert()->success('افزودن با موفقیت انجام گرفت', 'عملیات موفق');
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        return view('admin.users.edit' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminUserRequest $request , User $user)
    {
        try {
            DB::beginTransaction();
            $user->name = $request->name;
            $user->email = $request->email;
            if(!empty($request->password))
            {
                $user->password = $request->password;
            }
            $user->save();
            if ($request->has('confirm_email')){
                $user->markEmailAsVerified();
            }
            alert()->success('ویرایش با موفقیت انجام گرفت', 'عملیات موفق');
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            $user->delete();
            alert()->success('حذف با موفقیت انجام گرفت', 'عملیات موفق');
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }
        return back();
    }

    public function normal(User $user)
    {
        $user->update([
            'is_staff'=>false
        ]);
        return back();

    }

    public function staff(User $user)
    {
        $user->update([
            'is_staff'=>true
        ]);
        return back();
    }
}
