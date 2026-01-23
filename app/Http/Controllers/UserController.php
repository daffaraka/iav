<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::with('roles')->latest()->get();
        $data['title'] = 'Manajemen User';
        return view('dashboard.user.user-index', $data);
    }

    public function create()
    {
        $roles = Role::all();
        return view('dashboard.user.user-create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'employee_code' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'role' => 'required|exists:roles,name'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->assignRole($validated['role']);

        return redirect()->route('dashboard.user.index')
            ->with('success', 'User berhasil dibuat');
    }

    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('dashboard.user.user-show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $jabatans = User::whereNotIn('unit', ['BPS'])->pluck('jabatan')->unique()->values();
        $departemens = User::whereNotIn('unit', ['BPS'])->pluck('departemen')->unique()->values();
        $title = 'Edit User '.$user->name;
        // dd($jabatans);
        return view('dashboard.user.user-edit', compact('user', 'roles','jabatans','departemens','title'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'department' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'role' => 'required|exists:roles,name'
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('dashboard.user.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('dashboard.user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
