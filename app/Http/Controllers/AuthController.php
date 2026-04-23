<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function kirimOtp(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'Email tidak ditemukan');
    }

    $otp = rand(100000, 999999);

    $user->otp = $otp;
    $user->otp_expired_at = now()->addMinutes(5);
    $user->save();

    Mail::raw("Kode OTP kamu: $otp", function ($msg) use ($user) {
        $msg->to($user->email)->subject('Kode OTP Reset Password');
    });

    return redirect('/verifikasi-otp')->with('email', $user->email);
}

public function cekOtp(Request $request)
{
    $user = User::where('email', session('email'))->first();

    if (!$user) return back()->with('error','User tidak ditemukan');

    if ($user->otp != $request->otp) {
        return back()->with('error','OTP salah');
    }

    if (now()->gt($user->otp_expired_at)) {
        return back()->with('error','OTP kadaluarsa');
    }

    return redirect('/reset-password')->with('email', $user->email);
}

public function resetPassword(Request $request)
{
    $user = User::where('email', session('email'))->first();

    $user->password = Hash::make($request->password);
    $user->otp = null;
    $user->otp_expired_at = null;
    $user->save();

    return redirect('/login')->with('success','Password berhasil diubah');
}
}

