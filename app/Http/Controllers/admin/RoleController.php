<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\createRoleRequest;
use App\Http\Requests\admin\updateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::query();
        if ($key = request('search')){
            $roles = $roles->where('label','like', "%{$key}%")
                ->orWhere('name','like', "%{$key}%")
                ->orWhere('id','like', "%{$key}%");
        }
        $roles = $roles->latest()->paginate(20);
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
    public function store(createRoleRequest $request)
    {
        $role =  Role::create([
            'name'=>$request->name,
            'label'=>$request->label,
        ]);
        $role->permissions()->sync($request->permissions);
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
    public function update(updateRoleRequest $request, Role $role)
    {
        $role->update([
            'name'=> $request->name,
            'label'=> $request->label
        ]);
        $role->permissions()->sync($request->permissions);
        alert()->success('ویرایش با موفقیت انجام گرفت', 'عملیات موفق');
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
