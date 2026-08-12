<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginRole = $request->input('role');

        // ==========================================
        // 1. LOGIN SISWA (NIS & Tanggal Lahir)
        // ==========================================
        if ($loginRole === 'siswa') {
            $request->validate([
                'nis' => ['required', 'string'],
                'tanggal_lahir' => ['required', 'date'],
            ], [
                'nis.required' => 'NIS wajib diisi.',
                'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
                'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            ]);

            // Cari user berdasarkan NIS (disimpan di kolom nis_nip)
            $user = User::where('nis_nip', $request->nis)
                        ->where('role', 'siswa')
                        ->first();

            // Cek apakah user ada dan memiliki relasi profil siswa
            if ($user && $user->siswa) {
                // Samakan format tanggal (Y-m-d) untuk menghindari error format DB
                $dbTglLahir = Carbon::parse($user->siswa->tanggal_lahir)->format('Y-m-d');
                $inputTglLahir = Carbon::parse($request->tanggal_lahir)->format('Y-m-d');

                if ($dbTglLahir === $inputTglLahir) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->intended(route('siswa.dashboard'));
                }
            }

            return back()->withErrors([
                'nis' => 'NIS atau Tanggal Lahir yang Anda masukkan salah.',
            ])->onlyInput('nis');
        }

        // ==========================================
        // 2. LOGIN GURU / ADMIN (Username & Password)
        // ==========================================
        if ($loginRole === 'guru') {
            $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ], [
                'username.required' => 'Username wajib diisi.',
                'password.required' => 'Password wajib diisi.',
            ]);

            // Admin juga login melalui form Guru, jadi kita cari role 'guru' atau 'admin'
            $user = User::whereIn('role', ['guru', 'admin'])
                        ->where('nis_nip', $request->username)
                        ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();
                
                // Redirect otomatis menyesuaikan role aslinya (admin -> /admin/dashboard, guru -> /guru/dashboard)
                return redirect()->intended(route("{$user->role}.dashboard"));
            }

            return back()->withErrors([
                'username' => 'Username atau Password yang Anda masukkan salah.',
            ])->onlyInput('username');
        }

        // ==========================================
        // 3. LOGIN SATPAM (Username & Password)
        // ==========================================
        if ($loginRole === 'satpam') {
            $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ], [
                'username.required' => 'Username wajib diisi.',
                'password.required' => 'Password wajib diisi.',
            ]);

            $user = User::where('role', 'satpam')
                        ->where('nis_nip', $request->username)
                        ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended(route('satpam.dashboard'));
            }

            return back()->withErrors([
                'username' => 'Username atau Password yang Anda masukkan salah.',
            ])->onlyInput('username');
        }

        // Fallback jika role tidak dikenali / manipulasi form
        return back()->withErrors([
            'role' => 'Peran yang dipilih tidak valid.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}