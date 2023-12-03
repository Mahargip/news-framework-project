<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email'=> ['The provided credentials are incorrect.'],
                ])->redirectTo(route('posts'));
            }

            $token = $user->createToken('user login')->plainTextToken;
            // dd($token);
            return $token;
            // return redirect()->route('posts')->cookie('api_token', $token, 60)->withSuccess('Login Successful');
        }


    /////////////
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         // Email tidak ditemukan di database, berikan pesan kesalahan
    //         return back()->withErrors(['email' => 'Email not found']);
    //     }

    //     if (!Hash::check($request->password, $user->password)) {
    //         // Password tidak cocok, berikan pesan kesalahan
    //         return back()->withErrors(['password' => 'Incorrect password']);
    //     }

    //     // Jika email dan password sesuai, berikan token
    //     $token = $user->createToken('user login')->plainTextToken;

    //     return redirect()->route('posts')->cookie('api_token', $token, 60)->withSuccess('Login Successful');
    // }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }

    public function me(Request $request)
    {
        return response()->json(Auth::user());
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
