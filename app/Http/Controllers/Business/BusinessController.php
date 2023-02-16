<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\Business;

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
}
