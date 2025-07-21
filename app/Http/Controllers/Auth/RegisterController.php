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
            // Mengubah format 'volunteer_desa' menjadi 'Volunteer Desa' untuk dicari di DB
            $roleName = str_replace('_', ' ', ucwords($request->role));
            $jenisAkunId = \DB::table('jenis_akun')->where('jenisAkun', $roleName)->value('id');

            if (!$jenisAkunId) {
                return back()->withErrors(['role' => 'Jenis akun tidak valid.'])->withInput();
            }

            $akunId = \DB::table('akun')->insertGetId([
                'email'         => $request->email,
                'password'      => \Hash::make($request->password),
                'namaPengguna'  => $request->name,
                'jenis_akun_id' => $jenisAkunId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // Jika yang mendaftar adalah Volunteer Desa, buatkan entri portofolio kosong
            if ($request->role === 'volunteer_desa') {
                \DB::table('akun_komunitas')->insert([
                    'akun_id'   => $akunId,
                    'portofolio'=> null,
                ]);
            }

            return redirect()->route('reg-success')->with('success', 'Akun berhasil dibuat!');
        } catch (\Exception $e) {
            // Untuk debugging, Anda bisa log error: \Log::error($e->getMessage());
            return back()->withErrors(['register' => 'Gagal membuat akun. Silakan coba lagi.'])->withInput();
        }
    }
}
