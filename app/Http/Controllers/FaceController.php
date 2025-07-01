<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class FaceController extends Controller
{
    // Menampilkan halaman kamera
    public function index()
    {
        return view('face');
    }

    // Menyimpan hasil absensi
public function store(Request $request)
{
    $status = $request->input('hasil') ?? 'gagal'; // default 'gagal' jika tidak ada input

    // Tambahkan log ini untuk melihat user ID di storage/logs/laravel.log
    \Log::info('User saat absen:', ['id' => Auth::id()]);

    // Simpan ke database
    Absensi::create([
        'user_id' => Auth::id(),
        'status' => $status,
        'waktu' => now()
    ]);

    // Kirim response JSON berisi URL redirect
    if ($status === 'berhasil') {
        return response()->json(['redirect' => route('absen.success')]);
    } else {
        return response()->json(['redirect' => route('absen.fail')]);
    }

    }
}
