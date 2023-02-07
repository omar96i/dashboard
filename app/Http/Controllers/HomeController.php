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
            return view('home');
        }else{
            return view('auth.login');
        }
    }
}
