<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index() {
        $users = User::all();
        return view('users.users', compact('users'));
    }

    public function create() {
        return view('users.tambah-user');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:16',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->role == "admin" ? true : false,
        ]);

        return redirect()->route('users')->with('success', 'User created successfully.');
    }

    public function show($id) {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }
    
}
