<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function admin()
    {
        $totalPengaduan = Pengaduan::count();
        $totalUser = User::where('level', 'user')->count();
        $pengaduan = Pengaduan::orderBy('tanggal_lapor', 'desc')->get();
        return view("admin.dashboard_admin", [
            "pengaduan" => $pengaduan,
            "total" => $totalPengaduan,
            "user" => $totalUser
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route("login");
    }

    public function hapus_pengaduan($tanggal_lapor)
    {
        $cari = Pengaduan::where("tanggal_lapor", $tanggal_lapor)->first();
        $cari->delete();
        return redirect()->route("dashboard_admin")->with("berhasil", "berhasil hapus");
    }

    public function edit_pengaduan(Request $request, $title)
    {
        $pengaduan = Pengaduan::where("title", $title)->first();

        if (!$pengaduan) {
            return redirect()->back()->with("error", "Pengaduan tidak ditemukan");
        }

        $pengaduan->description_petugas = $request->input("description_petugas");
        $pengaduan->status_pengaduan = $request->input("status_pengaduan");
        $pengaduan->updated_at = now();

        if ($request->hasFile('image_petugas')) {
            $imageName = time() . '.' . $request->file('image_petugas')->extension();
            $request->file('image_petugas')->storeAs('public/pengaduan_images', $imageName);

            $pengaduan->image_petugas = 'pengaduan_images/' . $imageName;
        }

        $pengaduan->save();

        return redirect()->route("dashboard_admin")->with("berhasil_ubah", "Berhasil mengedit pengaduan");
    }

    public function pengguna_sistem()
    {
        $pengguna = User::where('level', 'user')->get();
        return view('admin.pengguna_sistem', [
            'data' => $pengguna,
        ]);
    }
    public function hapusPenggunaBanyak(Request $request)
    {
        $usernames = $request->input('usernames', []);
        if (empty($usernames)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dipilih']);
        }
        User::whereIn('username', $usernames)->delete();
        return response()->json(['success' => true]);
    }

}