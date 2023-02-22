<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\PersonalInformation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }

    public function get(){
        $users = [];
        if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
            $users = User::with('personal_information', 'business', 'roles')->where('id', '!=', 1)->role('admin')->get();
        }else if(auth()->user()->roles->pluck('name')[0] == 'admin'){
            $users = User::with('personal_information', 'business', 'roles')->where('id', '!=', 1)->where('business_id','=', auth()->user()->business_id )->get();
        }
        
        return response()->json(['status' => true, 'users' => $users ]);
    }

    public function store(Request $request){
        if(User::validarEmail($request->user['email']) > 0){
            return response()->json(['status' => false, 'msg' => 'El correo ingresado ya se encuentra registrado']);
        }
        //if(auth()->user()->business_id == $request->personal_information->business_id || auth()->user()->roles->pluck('name')[0] == 'super.admin'){
            $user = new User($request->user);
            $user->save();

            $user->assignRole($request->role);

            $personal_information = new PersonalInformation($request->personal_information);
            $personal_information->user_id = $user->id;
            $personal_information->save();

            return response()->json(['status' => true, 'user' => $user->load('personal_information', 'business')]);
        //}

        //return response()->json(['status' => false, 'msg' => 'No tienes permisos para realizar esta accion']);

    }

    public function update(User $user, Request $request){
        $user->update($request->user);
        $user->personal_information()->update($request->personal_information);
        $user->refresh()->syncRoles($request->role);

        return response()->json(['status' => true, 'user' => $user->load('personal_information', 'business')]);
    }

    public function delete(User $user){
        $user->delete();
        return response()->json(['status' => true]);
    }

    public function getRoles(){
        if(auth()->user()->roles->pluck('name')[0] == 'super.admin'){
            $roles = Role::whereNotIn('name', ['super.admin', 'cobrador'])->get();
        }else{
            $roles = Role::whereNotIn('name', ['super.admin', 'admin'])->get();
        }
        return response()->json(['roles' => $roles]);
    }
}
