<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show ()
    {
        return view ('register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'admin_id' => Auth::id(),  // Menyimpan id admin yang login
        ]);

        return redirect('/dashboard')->with('success', 'User berhasil ditambahkan!');
    }

    // login user
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $credentials = $request->only('name', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function datauser ()
    {
        $users = User::with(['admin'])->get(); // Tambah 'admin'
        return view('datauser', compact('users'));
    }

    public function user (Request $request)
    {
        return response()->json($request->user());
    }

    public function tableakun() {
        // Mengambil semua user
        $users = User::all(); // Bisa menggunakan paginasi jika datanya banyak, misalnya User::paginate(10);

        // Mengirim data ke view
        return view('dashboard', compact('users'));
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Log out berhasil.']);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }
}