<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function get(){
        return response()->json(['business' => Business::get()]);
    }
}
