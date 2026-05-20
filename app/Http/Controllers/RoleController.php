<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index() {
        $data['title'] = 'Manajemen Roles';
        $data['roles'] = Role::orderBy('id', 'DESC')->get();
        return view('dashboard.role.role-index', $data);
    }

    public function create() {
        $data['title'] = 'Tambah Role';
        $data['permissions'] = Permission::get();
        return view('dashboard.role.role-create', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        if($request->has('permission')) {
            $role->syncPermissions($request->input('permission'));
        }

        return redirect()->route('role.index')
                        ->with('success','Role berhasil ditambahkan');
    }

    public function edit($id) {
        $data['title'] = 'Edit Role';
        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::get();
        $data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('dashboard.role.role-edit', $data);
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'nullable|array',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        if($request->has('permission')) {
            $role->syncPermissions($request->input('permission'));
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('role.index')
                        ->with('success','Role berhasil diupdate');
    }

    public function destroy($id) {
        Role::find($id)->delete();
        return redirect()->route('role.index')
                        ->with('success','Role berhasil dihapus');
    }
}
