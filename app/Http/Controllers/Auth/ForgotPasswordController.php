<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');
        $user = DB::table('akun')->where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan'])->withInput();
        }

        // Simpan email ke session
        session(['reset_email' => $email]);
        return redirect()->route('password.reset.form');
    }

    public function showChangePasswordForm()
    {
        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }
        return view('account.change-password', compact('email'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = \DB::table('akun')->where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        \DB::table('akun')->where('email', $request->email)->update([
            'password' => Hash::make($request->password),
            'updated_at' => now(),
        ]);

        // Hapus session reset_email
        $request->session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah. Silakan login.');
    }
}
