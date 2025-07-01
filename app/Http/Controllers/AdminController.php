<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Lokasi;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $hariIni = Carbon::now()->toDateString();
        $hadirHariIni = Absensi::whereDate('waktu', $hariIni)->count();
        $jumlahBerhasil = Absensi::where('status', 'berhasil')->count();

        return view('dashboard', compact('hadirHariIni', 'jumlahBerhasil'));
    }

    // Menampilkan data absensi
    public function absensi()
    {
        $absensi = Absensi::with('user')->orderBy('waktu', 'desc')->get();
        return view('admin.absensi', compact('absensi'));
    }

    // Menampilkan form pengaturan lokasi
    public function lokasi()
    {
         $lokasi = Lokasi::first() ?? new Lokasi(); // <--- ini kuncinya
    return view('admin.lokasi', compact('lokasi'));
    }

    // Menyimpan pengaturan lokasi
    public function updateLokasi(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat'    => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $lokasi = Lokasi::first() ?? new Lokasi();

        $lokasi->nama_lokasi = $request->nama_lokasi;
        $lokasi->alamat = $request->alamat;
        $lokasi->latitude = $request->latitude;
        $lokasi->longitude = $request->longitude;
        $lokasi->aktif = $request->has('is_active');
        $lokasi->save();

        return redirect()->route('admin.lokasi')->with('success', 'Pengaturan lokasi berhasil diperbarui.');
    }

    public function index()
{
    $hariIni = Carbon::now()->toDateString();

    $hadirHariIni = Absensi::whereDate('created_at', $hariIni)->count(); // GANTI dari 'waktu' kalau emang pakai created_at
    $jumlahBerhasil = Absensi::where('status', 'berhasil')->count();

    return view('admin.dashboard', compact('hadirHariIni', 'jumlahBerhasil'));
}

public function toggleLokasi()
{
    $lokasi = Lokasi::first();
    $lokasi->aktif = !$lokasi->aktif; // ganti dari is_active
    $lokasi->save();

    return redirect()->route('admin.lokasi')->with('success', 'Status lokasi berhasil diperbarui.');
}





}
