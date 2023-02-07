<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Validamos si el usuario existe y lo autentificamos si este existe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
    */
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

    /**
     * Cerramos sesion.
     *
     * @return route
    */
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }


    /**
     * Funcion sin documentar
     *
     * @return view
    */
    public function index(){
        if(auth()->user()){
            return redirect()->route('home');
        }else{
            return view('auth.login');
        }
    }
}
