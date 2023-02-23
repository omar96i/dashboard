<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\Business;
use App\Models\User;
use App\Models\User\PersonalInformation;

class BusinessController extends Controller {

	public function index(){
		return view("business.index");
	}

	public function get(){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$data = [
						'status'=>true,
						'business'=>Business::get()
				    ];
			return response()->json($data);
		}
		return $this->unauthorizedAccess();
	}

	public function store(Request $request){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$business = new Business($request->business);
			$business->save();
			$data = [
						'status' => true,
						'business' => $business
					];
			return response()->json($data);
		}
		return $this->unauthorizedAccess();
	}

	public function update(Business $business, Request $request){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$business->update($request->business);
			$data = [
						'status' => true,
						'business' => $request->business
					];
			return response()->json($data);
		}
		return $this->unauthorizedAccess();
	}

	public function delete(Business $business){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$business->delete();
	        return response()->json(['status' => true]);
    	}
    	return $this->unauthorizedAccess();
	}

	public function getCollectors(Business $business){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin' || auth()->user()->roles->pluck('name')[0] == 'admin') {
			$collectors = User::with('personal_information')->where('business_id','=',$business->id)
															->role('cobrador')
															->get();

	        return response()->json(['status'=>true, 'business'=>$business, 'collectors'=>$collectors]);
	    }
    	return $this->unauthorizedAccess();
	}

	public function unauthorizedAccess(){
		$data = [
					'status' => false,
					'codigo' => 401
				];
		return response()->json($data);
	}
}
