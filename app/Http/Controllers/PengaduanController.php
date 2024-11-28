<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengaduanController extends Controller
{
    public function pengaduan()
    {
        $userId = auth()->id();

        $pengaduan = Pengaduan::with('user')
            ->where('user_id', $userId)
            ->orderBy('tanggal_lapor', 'desc')
            ->get();

        return response()->json([
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "Data berhasil ditampilkan",
            ],
            "data" => [
                "pengaduan" => $pengaduan->map(function ($p) {
                    return [
                        "id" => $p->id,
                        "user" => $p->user->name,
                        "title" => $p->title,
                        "description" => $p->description,
                        "status_pengaduan" => $p->status_pengaduan,
                        "kategori_pengaduan" => $p->kategori_pengaduan,
                        "description_petugas" => $p->description_petugas,
                        "tanggal_lapor" => $p->tanggal_lapor,
                        "updated_at" => $p->updated_at,
                        "image" => $p->image ? asset('storage/' . $p->image) : null,
                        "image_petugas" => $p->image_petugas ? asset('storage/' . $p->image_petugas) : null,
                    ];
                })
            ]
        ]);
    }

    public function semua_pengaduan()
    {
        $ep = Pengaduan::orderBy('tanggal_lapor', 'desc')->get();

        return response()->json([
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "Data berhasil ditampilkan",
            ],
            "data" => [
                "pengaduan" => $ep->map(function ($p) {
                    return [
                        "id" => $p->id,
                        "user" => optional($p->user)->name,
                        "title" => $p->title,
                        "description" => $p->description,
                        "status_pengaduan" => $p->status_pengaduan,
                        "kategori_pengaduan" => $p->kategori_pengaduan,
                        "description_petugas" => $p->description_petugas,
                        "tanggal_lapor" => $p->tanggal_lapor,
                        "updated_at" => $p->updated_at,
                        "image" => $p->image ? asset('storage/' . $p->image) : null,
                        "image_petugas" => $p->image_petugas ? asset('storage/' . $p->image_petugas) : null,
                    ];
                })
            ]
        ], 200);
    }

    public function add_pengaduan(Request $request)
    {
        $validator = $this->validate($request, [
            "title" => ["required", "string", "min:4", "max:200"],
            "description" => ["required", "string", "min:10"],
            "kategori_pengaduan" => ["required", "string", "min:3", "max:100"],
            "image" => ["image", "mimes:jpg,jpeg,png", "max:3000", "required"],
        ]);
        $badWords = ['bego', 'tolol', 'goblok', 'anjing', 'babi', 'tai', 'beloon', 'tololll'];

        $combinedText = strtolower($request->title . ' ' . $request->description . ' ' . $request->kategori_pengaduan);
        foreach ($badWords as $word) {
            if (preg_match("/\b$word\b/", $combinedText)) {
                return response()->json([
                    "meta" => [
                        "code" => 400,
                        "status" => "gagal",
                        "message" => "Pengaduan mengandung kata-kata kasar",
                    ],
                    "data" => null
                ], 400);
            }
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pengaduan_images', 'public');
        }

        $data = Pengaduan::create([
            "user_id" => auth()->id(),
            "title" => $request->title,
            "description" => $request->description,
            "status_pengaduan" => "PENDING",
            "kategori_pengaduan" => $request->kategori_pengaduan,
            "description_petugas" => "-",
            "image" => $imagePath,
            "image_petugas" => null,
        ]);

        if (!$data) {
            return response()->json([
                "meta" => [
                    "code" => 422,
                    "status" => "gagal",
                    "message" => "Pengaduan gagal ditambah",
                ],
                "data" => [
                    "pengaduan" => "null",
                ]
            ], 422);
        } else {
            return response()->json([
                "meta" => [
                    "code" => 200,
                    "status" => "success",
                    "message" => "Pengaduan berhasil ditambah",
                ],
                "data" => [
                    "pengaduan" => $data,
                ]
            ], 200);
        }
    }

    public function delete_pengaduan($title)
    {
        $cari_pengaduan = Pengaduan::where("title", $title)->first();
        $cari_pengaduan->delete();
        if (!$cari_pengaduan) {
            return response()->json([
                "meta" => [
                    "code" => 422,
                    "status" => "gagal",
                    "message" => "Pengaduan tidak di temukan",
                ],
                "data" => [
                    "pengaduan" => null,
                ]
            ], 422);
        } else {
            return response()->json([
                "meta" => [
                    "code" => 200,
                    "status" => "success",
                    "message" => "Pengaduan berhasil di hapus",
                ],
            ], 200);
        }
    }

    public function cari($keyword)
    {
        $caridata = Pengaduan::where('title', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->orWhere('kategori_pengaduan', 'like', "%$keyword%")
            ->with('user')
            ->get();

        if ($caridata->isEmpty()) {
            return response()->json([
                "meta" => [
                    "code" => 422,
                    "status" => "gagal",
                    "message" => "Pengaduan tidak ditemukan",
                ],
                "data" => [
                    "pengaduan" => null,
                ]
            ], 422);
        } else {
            return response()->json([
                "meta" => [
                    "code" => 200,
                    "status" => "success",
                    "message" => "Pengaduan berhasil ditemukan",
                ],
                "data" => [
                    "pengaduan" => $caridata,
                ]
            ], 200);
        }
    }
    public function view($title)
    {
        $caridata = Pengaduan::where('title', $title)->first();
        if (!$caridata) {
            return response()->json([
                "meta" => [
                    "code" => 422,
                    "status" => "gagal",
                    "message" => "Pengaduan tidak ditemukan",
                ],
                "data" => [
                    "pengaduan" => null,
                ]
            ], 422);
        } else {
            return response()->json([
                "meta" => [
                    "code" => 200,
                    "status" => "success",
                    "message" => "Pengaduan berhasil ditemukan",
                ],
                "data" => [
                    "pengaduan" => $caridata,
                ]
            ], 200);
        }
    }

}