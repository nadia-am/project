<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CreatePermissionRequest;
use App\Http\Requests\admin\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-permissions')->only(['index']);
        $this->middleware('can:edit-permissions')->only(['edit','update']);
        $this->middleware('can:create-permissions')->only(['create','store']);
        $this->middleware('can:delete-permissions')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::latest()->filter(request('search'))->paginate(20);
        return view('admin.permissions.all' , compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePermissionRequest $request)
    {
        try {
            Permission::create([
                'name'=>$request->name,
                'label'=>$request->label,
            ]);
            alert()->success('افزودن با موفقیت انجام گرفت', 'عملیات موفق');
        }catch (\Exception $e){
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }

        return redirect(route('admin.permissions.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit' , compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try {
            $permission->name = $request->name;
            $permission->label = $request->label;
            $permission->save();
            alert()->success('ویرایش با موفقیت انجام گرفت', 'عملیات موفق');
        }catch (\Exception $e){
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }
        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        alert()->success('حذف با موفقیت انجام گرفت', 'عملیات موفق');
        return back();
    }
}
