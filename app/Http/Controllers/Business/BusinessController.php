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
		$data = [
					'status'=>true,
					'business'=>Business::get()
			    ];
		return response()->json($data);
	}

	public function store(Request $request){
		$business = new Business($request->business);
		$business->save();

		$data = [
					'status' => true,
					'business' => $business
				];

		return response()->json($data);
	}

	public function update(Business $business, Request $request){
		$business->update($request->business);

		$data = [
					'status' => true,
					'business' => $request->business
				];

		return response()->json($data);
	}

	public function delete(Business $business){
		$business->delete();
        return response()->json(['status' => true]);
	}

	public function getCollectors(Business $business){
		
		$collectors = User::with('personal_information')->where('business_id','=',$business->id)
														->role('cobrador')
														->get();
		

		/*$collector_aux = PersonalInformation::whereHas('user', function($query) use ($business){
			$query->where('business_id','=',$business->id);
		})->get();*/

        return response()->json(['status'=>true, 'business'=>$business, 'collectors'=>$collectors]);
	}

}
