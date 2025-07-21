<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:akun,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:volunteer_desa,masyarakat_desa',
            'terms'    => 'accepted',
        ]);

        try {
            $jenisAkunId = \DB::table('jenis_akun')->where('jenisAkun', str_replace('_', ' ', ucwords($request->role)))->value('id');
            if (!$jenisAkunId) {
                return back()->withErrors(['role' => 'Jenis akun tidak valid.'])->withInput();
            }

            $akunId = \DB::table('akun')->insertGetId([
                'email'         => $request->email,
                'password'      => \Hash::make($request->password),
                'namaPengguna'  => $request->name,
                'fotoProfil'    => '',
                'nomorTelepon'  => '',
                'jenis_akun_id' => $jenisAkunId,
                'created_at'    => now(),
            ]);

            // Jika yang mendaftar adalah Volunteer Desa, buatkan entri portofolio kosong
            if ($request->role === 'volunteer_desa') {
                \DB::table('akun_komunitas')->insert([
                    'akun_id'   => $akunId,
                    'portofolio'=> '', // Portofolio awalnya kosong
                ]);
            }

            return redirect()->route('reg-success')->with('success', 'Akun berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withErrors(['register' => 'Gagal membuat akun. Silakan coba lagi.'])->withInput();
        }
    }
}
