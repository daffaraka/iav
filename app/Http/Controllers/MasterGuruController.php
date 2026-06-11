<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class MasterGuruController extends Controller
{
    public function index()
    {
        $guru = User::role(['guru', 'walikelas'])->latest()->get();
        return Inertia::render('MasterGuru/master-guru-index', [
            'guru' => $guru
        ]);
    }

    public function create()
    {
        return Inertia::render('MasterGuru/master-guru-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['guru', 'walikelas'])],
            'kelas' => 'nullable|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('master-guru.index')->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = User::findOrFail($id);
        return Inertia::render('MasterGuru/master-guru-edit', [
            'guru' => $guru,
            'guru_role' => $guru->roles->first()->name ?? 'guru'
        ]);
    }

    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($guru->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($guru->id)],
            'role' => ['required', Rule::in(['guru', 'walikelas'])],
            'kelas' => 'nullable|string'
        ]);

        $guru->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'kelas' => $request->kelas,
        ]);

        if ($request->filled('password')) {
            $guru->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $guru->syncRoles([$request->role]);

        return redirect()->route('master-guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();
        return redirect()->route('master-guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}
