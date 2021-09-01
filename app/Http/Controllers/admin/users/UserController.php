<?php

namespace App\Http\Controllers\admin\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CreateAdminUserRequest;
use App\Http\Requests\admin\UpdateAdminUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-user')->only(['index']);
        $this->middleware('can:create-user')->only(['create','store']);
        $this->middleware('can:edit-user')->only(['edit' , 'update']);
        $this->middleware('can:delete-user')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query();
        if ($key = request('search')){
            $users = $users->where('email','like', "%{$key}%")
                ->orWhere('name','like', "%{$key}%")
                ->orWhere('id','like', "%{$key}%");
        }

        if (Gate::allows('show-staff-user')){
            if ($key = request('admin')){
                $users = $users->where('is_superuser','=', 1)
                    ->orWhere('is_staff','=', 1);
            }
        }else{
            $users = $users->where('is_superuser','=', 0)
                ->orWhere('is_staff','=', 0);
        }
        $users = $users->latest()->paginate(10);
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
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);
        if ($request->has('confirm_email')){
            $user->markEmailAsVerified();
        }
        alert()->success('افزودن با موفقیت انجام گرفت', 'عملیات موفق');
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
        $user->delete();
        alert()->success('حذف با موفقیت انجام گرفت', 'عملیات موفق');
        return back();
    }
}
