<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        return view("admin.roles.index", compact('request', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_permissions = Permission::get();
        $group_permissions = $all_permissions->groupBy('group_name');
        return view("admin.roles.create", compact(
            'all_permissions',
            'group_permissions',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tableNames = config('permission.table_names');
        $this->validate($request, [
            "name" => [
                "required", "string",
                Rule::unique($tableNames['roles'])
            ]
        ]);
        try {
            DB::beginTransaction();
            $role = Role::create([
                'name' => $request->name
            ]);
            $permissions = $request->input('permissions');
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }
            DB::commit();
            return back()->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('Somthing is wrong!', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $all_permissions = Permission::get();
        $group_permissions = $all_permissions->groupBy('group_name');
        $role = Role::with('permissions')->where('id', $id)->first();
        return view("admin.roles.edit", compact('role', 'all_permissions', 'group_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tableNames = config('permission.table_names');
        $this->validate($request, [
            "name" => [
                "required", "string",
                Rule::unique($tableNames['roles'])
                    ->ignore($id)
            ]
        ]);
        try {
            DB::beginTransaction();
            $role = Role::with('permissions')->where('id', $id)->first();
            $role->update([
                'name' => $request->name
            ]);
            $permissions = $request->input('permissions');
            if (!empty($permissions)) {
                if ($role->permissions) {
                    $role->permissions()->detach();
                }
                $role->syncPermissions($permissions);
            }
            DB::commit();
            return back()->with('success', 'It has been updated.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('Somthing is wrong!', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
