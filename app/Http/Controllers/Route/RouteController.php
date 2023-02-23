<?php

namespace App\Http\Controllers\Route;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route\Route;
use App\Models\Route\RouteCollector;
use App\Models\Business\Business;
use Spatie\Permission\Models\Role;

class RouteController extends Controller {
    
	public function index(){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$routes = [];
            $routes = Route::with('business', 'route_collector.collector.personal_information')->get();
			$data = [
						'status'=>true,
						'routes'=>$routes,
						'business'=>Business::get()
				    ];
			return view("route.index", $data);
        }else if(auth()->user()->roles->pluck('name')[0] == 'admin'){
            $routes = [];
            $routes = Route::with('business', 'route_collector.collector.personal_information')->where('business_id','=', auth()->user()->business_id )->get();
			$data = [
						'status'=>true,
						'routes'=>$routes,
						'business'=>Business::get()
				    ];
			return view("route.index", $data);
        }
        return $this->unauthorizedAccess();
	}

	public function get(){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$routes = Route::with('business', 'route_collector.collector.personal_information')->get();
			$data = [
						'status'=>true,
						'routes'=>$routes,
						'business'=>Business::get()
				    ];
			return response()->json($data);
        }else if(auth()->user()->roles->pluck('name')[0] == 'admin'){
            $routes = Route::with('business', 'route_collector.collector.personal_information')->where('business_id','=', auth()->user()->business_id )->get();
            $data = [
						'status'=>true,
						'routes'=>$routes,
						'business'=>Business::get()
				    ];
			return response()->json($data);
        }
        return $this->unauthorizedAccess();
	}

	public function store(Request $request){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$route = new Route($request->route);
			$route->save();
			$data = [
						'status' => true,
						'route' => $route->load('business', 'route_collector')
					];
			return response()->json($data);
		}
		return $this->unauthorizedAccess();
	}

	public function update(Route $route, Request $request){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$route->update($request->route);
			$data = [
						'status' => true,
						'route' => $route->load('business', 'route_collector.collector.personal_information')
					];
			return response()->json($data);
        }else if(auth()->user()->roles->pluck('name')[0] == 'admin'){
            $route->update($request->route);
			
			if ($request->route_collector['collector_id']) {
				$antecedente = RouteCollector::where('route_id','=',$route->id)
											 ->where('collector_id','=',$request->route_collector['collector_id'])
											 ->where('status','=','active')
											 ->get();
				if (sizeof($antecedente)==0){
					RouteCollector::where('route_id', '=', $route->id)
								  ->where('status', '=', 'active')
								  ->update(['status'=>'inactive']);

					$new_route_collector = new RouteCollector([
																'collector_id'=>$request->route_collector['collector_id'],
																'route_id'=>$route->id,
																'status'=>'active'
															   ]);
					$new_route_collector->save();
				}
			}

			$data = [
						'status' => true,
						'route' => $route->load('business', 'route_collector.collector.personal_information'),
						'collector_id' => $request->route_collector['collector_id'],
					];
			return response()->json($data);
        }
        return $this->unauthorizedAccess();
	}

	public function delete(Route $route){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
			$route->delete();
	        return response()->json(['status' => true]);
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
