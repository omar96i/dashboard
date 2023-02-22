<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
     /**
     * funcion sin documentar
     * @return view
    */
    public function index(){
        if(auth()->user()){
            if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
                return redirect()->route('business.index');
            }else if (auth()->user()->roles->pluck('name')[0] == 'admin') {
                return redirect()->route('route.index');
            }else{
                echo "Redireccionar al inicio del usuario: ".auth()->user()->roles->pluck('name')[0];
            }
        }else{
            return view('auth.login');
        }
    }
}
