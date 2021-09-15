<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CreateRoleRequest;
use App\Http\Requests\admin\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-roles')->only(['index']);
        $this->middleware('can:edit-roles')->only(['edit','update']);
        $this->middleware('can:create-roles')->only(['create','store']);
        $this->middleware('can:delete-roles')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $roles = Role::query();
//        if ($key = request('search')){
//            $roles = $roles->where('label','like', "%{$key}%")
//                ->orWhere('name','like', "%{$key}%")
//                ->orWhere('id','like', "%{$key}%");
//        }
        $roles = Role::latest()->filter(request('search'))->paginate(20);
        return view('admin.roles.all' , compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $role =  Role::create([
                'name'=>$request->name,
                'label'=>$request->label,
            ]);
            $role->permissions()->sync($request->permissions);
            alert()->success('افزودن با موفقیت انجام گرفت', 'عملیات موفق');
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }

        return redirect(route('admin.roles.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit' , compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();
            $role->update([
                'name'=> $request->name,
                'label'=> $request->label
            ]);
            $role->permissions()->sync($request->permissions);
            alert()->success('ویرایش با موفقیت انجام گرفت', 'عملیات موفق');
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }

        return redirect(route('admin.roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return back();
    }
}
