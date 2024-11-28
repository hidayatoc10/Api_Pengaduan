<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = $request->validate([
            "email" => ["required", "min:5", "max:50"],
            "password" => ["required", "min:5", "max:100"],
        ]);

        $email = $validator['email'];
        $password = $validator['password'];

        $cek = User::where('email', $email)->first();
        if (!$cek) {
            return response()->json([
                "status" => false,
                "message" => "Email atau Password Salah Coba Lagi",
            ], 422);
        } else if (!Hash::check($password, $cek->password)) {
            return response()->json([
                "status" => false,
                "message" => "Email atau Password Salah Coba Lagi",
            ], 422);
        } else {
            $token = $cek->createToken("authToken")->plainTextToken;

            return response()->json([
                "status" => true,
                "message" => "Login Berhasil",
                "data" => [
                    "id" => $cek->id,
                    "name" => $cek->name,
                    "username" => $cek->username,
                    "email" => $cek->email,
                    "tanggal_registrasi" => $cek->tanggal_registrasi,
                    "token" => $token,
                ],
            ], 200);
        }
    }


    public function registrasi(Request $request)
    {
        $validator = $request->validate([
            "name" => ["required", "string", "min:3", "max:50"],
            "username" => ["required", "string", "min:3", "max:50", "unique:users"],
            "email" => ["required", "min:3", "max:50", "unique:users", "email"],
            "password" => ["required", "min:8", "max:100"],
        ]);

        $user = User::create([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "level" => "user",
        ]);

        $user->refresh();
        if ($user) {
            $token = $user->createToken("authToken")->plainTextToken;
            return response()->json([
                "status" => true,
                "message" => "Registrasi Berhasil",
                "tanggal_registrasi" => $user->tanggal_registrasi,
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "username" => $user->username,
                    "email" => $user->email,
                    "level" => "user",
                    "token" => $token,
                ],
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Registrasi gagal, coba lagi",
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();

            return response()->json([
                "status" => true,
                "message" => "Logout berhasil",
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Tidak ada user yang login",
            ], 422);
        }
    }

    public function user()
    {
        $user = auth()->user();
        if ($user) {
            return response()->json([
                "meta" => [
                    "code" => 200,
                    "status" => "success",
                    "message" => "Pengaduan berhasil ditampilkan",
                    "token" => $user->createToken("authToken")->plainTextToken,
                ],
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "username" => $user->username,
                    "email" => $user->email,
                    "tanggal_registrasi" => $user->tanggal_registrasi,
                ]
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "User tidak ditemukan atau anda ingin mencoba masuk tanpa login",
            ], 422);
        }
    }

    public function login_admin()
    {
        return view("login");
    }

    public function login_post(Request $request)
    {
        $validator = $this->validate($request, [
            "email" => ["required", "min:5", "max:50", "email", "string"],
            "password" => ["required", "min:7", "max:50"],
        ]);

        if (Auth::attempt($validator)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->level === 'admin') {
                return redirect()->intended('dashboard_admin');
            } elseif ($user->level === 'user') {
                return redirect()->intended('logout_user');
            }
        }
        return redirect()->back()->with("gagal", "Login Gagal");
    }

    public function logout_user()
    {
        auth()->logout();
        return redirect()->route("login");
    }

    public function edit_user($username, Request $request)
    {
        $user = User::where("username", $username)->first();
        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "User tidak ditemukan.",
            ], 404);
        }

        $validator = $request->validate([
            "name" => ["required", "string", "min:3", "max:50"],
            "username" => ["required", "string", "min:3", "max:50", "unique:users,username," . $user->id],
            "email" => ["required", "min:3", "max:50", "unique:users,email," . $user->id, "email"],
            "password" => ["nullable", "min:8", "max:100"],
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json([
            "status" => true,
            "message" => "User berhasil diupdate",
            "data" => $user,
        ], 200);
    }
}