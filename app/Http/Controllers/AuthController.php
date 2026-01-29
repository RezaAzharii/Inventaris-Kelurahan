<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peminjam;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    protected $redirectTo = '/dashboard';

    public function loginForm()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'no_hp'    => 'required|string|max:20',
            'alamat'   => 'required|string',
        ]);

        DB::transaction(function () use ($request) {

            $peminjam = Peminjam::create([
                'nama_peminjam' => $request->nama,
                'email'         => $request->email,
                'no_telp'         => $request->no_telp,
                'alamat'        => $request->alamat,
            ]);

            User::create([
                'name'        => $request->nama,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'role'        => 'peminjam',
                'id_peminjam' => $peminjam->id_peminjam,
            ]);
        });

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil, silakan login.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }

    public function changePasswordForm()
    {
        return view('auth.passwords.change-password');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $password_field_name = 'new_password';
        $user->password = Hash::make($request->$password_field_name);
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
    }

    public function forgotPasswordForm()
    {
        return view('auth.passwords.email');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        }
        return back()->withErrors(['email' => trans($response)]);
    }
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                $this->guard()->login($user);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect($this->redirectPath())->with('status', trans($response));
        }

        return back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
    }
    protected function broker()
    {
        return Password::broker();
    }
    protected function guard()
    {
        return Auth::guard();
    }
    protected function redirectPath()
    {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}