<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $data['title'] = 'Roles Manajemen';
    }

    public function create() {
        $data['title'] = 'Roles Manajemen';
    }

    public function store(Request $request) {
        $data['title'] = 'Roles Manajemen';
    }

    public function edit($id) {
        $data['title'] = 'Roles Manajemen';
    }

    public function update($id, Request $request) {
        $data['title'] = 'Roles Manajemen';
    }

    public function destroy($id) {
        $data['title'] = 'Roles Manajemen';
    }
}
