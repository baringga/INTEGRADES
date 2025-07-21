<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    // HAPUS FUNGSI index() DARI SINI KARENA SUDAH TIDAK DIGUNAKAN

    // Menampilkan form untuk membuat pengaduan baru
    public function create()
    {
        return view('pengaduan.create');
    }

    // Menyimpan pengaduan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'akun_id' => Auth::id(),
            'judul' => $request->judul,
            'isi_pengaduan' => $request->isi_pengaduan,
            'lokasi' => $request->lokasi,
            'foto' => $path,
            'status' => 'dilaporkan',
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil dikirim!');
    }
}
