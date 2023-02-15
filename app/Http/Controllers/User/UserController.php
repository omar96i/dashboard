<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\PersonalInformation;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }

    public function get(){
        return response()->json(['status' => true, 'users' => User::with('personal_information', 'business')->where('id', '!=' , 1)->get()]);
    }

    public function store(Request $request){
        $user = new User($request->user);
        $user->save();

        $personal_information = new PersonalInformation($request->personal_information);
        $personal_information->user_id = $user->id;
        $personal_information->save();

        return response()->json(['status' => true, 'user' => $user->load('personal_information', 'business')]);
    }

    public function update(User $user, Request $request){
        $user->update($request->user);
        $user->personal_information()->update($request->personal_information);

        return response()->json(['status' => true, 'user' => $user->load('personal_information', 'business')]);
    }

    public function delete(User $user){
        $user->delete();
        return response()->json(['status' => true]);
    }
}
