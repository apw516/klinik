<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // <--- TAMBAHKAN BARIS INI
use Carbon\Carbon;

class authController extends Controller
{
    public function index()
    {
        return view('Auth.index');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->is_activated == 1) {
                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login')->with('loginError', 'User belum diaktivasi !');
            }
        }
        return back()->with('loginError', 'Login gagal !');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function register(Request $request)
    {
        // 1. Validasi Input Data
        $datenow = Carbon::now();
        $request->validate([
            'nama' => 'required|string|max:255',
            'username'    => 'required|string|min:4|max:50|unique:user,username',
            'password'    => 'required|string|min:6',
        ], [
            // Kustom notifikasi pesan error (Bahasa Indonesia)
            'nama.required' => 'Nama lengkap dan gelar wajib diisi.',
            'username.required'    => 'Username wajib diisi.',
            'username.min'         => 'Username minimal 4 karakter.',
            'username.unique'      => 'Username sudah digunakan oleh pengguna lain.',
            'password.required'    => 'Password wajib diisi.',
            'password.min'         => 'Password minimal harus 6 karakter.',
        ]);

        try {
            // 2. Simpan Data ke Tabel Users
            User::create([
                'nama'     => $request->nama, // Dipetakan ke kolom 'name' bawaan Laravel
                'username' => $request->username,
                'hak_akses' => 2,
                'id_klinik' => 1,
                'tanggal_entry' => $this->get_now(),
                'password' => Hash::make($request->password), // WAJIB di-bcrypt demi keamanan
                'is_activated' => 1, // Otomatis aktif saat daftar (opsional)
            ]);
            // 3. Redirect ke Halaman Login dengan Pesan Sukses
            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silahkan login.');
        } catch (\Exception $e) {
            // Jika terjadi kegagalan sistem / database crash
            return redirect()->back()
                ->withInput($request->except('password'))
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    public function get_now()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $now = $date . ' ' . $time;
        return $now;
    }
}
