<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserUnitPreference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage() {
        return view('auth.signin');
    }

    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if($user == null) {
            return redirect()
            ->back()
            ->with('error', 'User Tidak Ditemukan!!');
        }

        if(!Hash::check($request->password, $user->password)){
           return redirect()
           ->back()
           ->with('error', 'Password Salah!'); 
        }

        $request->session()->regenerate();
        $request->session()->put('isLogged', true);
        $request->session()->put('userId', $user->id);
        $request->session()->put('role', 'user');


        return redirect()->route('user-dashboard', [
            'id' => $user->id,
        ]);
    }

    public function logout(Request $request) {
        session()->forget('isLogged');
        session()->forget('userId');
        session()->forget('role');

        return redirect()->route('auth.login');
    }

    public function registerPage() {
        return view('auth.register');
    }

    public function register(Request $request) {
        //Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:50|',
            'dob' => 'required|date',
            'gender' => 'required|string|in:L,P',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Enkripsi password
        $validatedData['password'] = Hash::make($validatedData['password']);

        //Buat user baru
        $user = User::create([
            'name' => $validatedData['name'],
            'dob' => $validatedData['dob'],
            'gender' => $validatedData['gender'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);

        //Begining of tambahkan preferensi unit default untuk pengguna baru. Next update terkait fitur settings/preferences
        $defaultItemUnitIds = [2, 4, 6, 8, 10, 12, 13, 14];

        foreach ($defaultItemUnitIds as $itemUnitId) {
            UserUnitPreference::create([
                'user_id' => $user->id,
                'item_unit_id' => $itemUnitId,
            ]);
        }
        //End of tambahkan preferensi unit default untuk pengguna baru.

        return redirect()->route('auth.loginPage')->with('success', 'User telah berhasil didaftarkan.');
    }
}
