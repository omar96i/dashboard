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
		return view("route.index");
	}

	public function get(){
		$routes = [];
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
            $routes = Route::with('business', 'route_collector.collector.personal_information')->get();
        }else if(auth()->user()->roles->pluck('name')[0] == 'admin'){
            $routes = Route::with('business', 'route_collector.collector.personal_information')->where('business_id','=', auth()->user()->business_id )->get();
        }

		$data = [
					'status'=>true,
					'routes'=>$routes,
					'business'=>Business::get()
			    ];
		return response()->json($data);
	}

	public function store(Request $request){
		$route = new Route($request->route);
		$route->save();

		$data = [
					'status' => true,
					'route' => $route->load('business', 'route_collector')
				];

		return response()->json($data);
	}

	public function update(Route $route, Request $request){
		$route->update($request->route);
		
		RouteCollector::where('route_id', '=', $route->id)->update(['status'=>'inactive']);
		
		if ($request->route_collector['collector_id']) {
			$new_route_collector = new RouteCollector([
														'collector_id'=>$request->route_collector['collector_id'],
														'route_id'=>$route->id,
														'status'=>'active'
													   ]);
			$new_route_collector->save();
		}

		$data = [
					'status' => true,
					'route' => $route->load('business', 'route_collector.collector.personal_information'),
					'collector_id' => $request->route_collector['collector_id'],
				];

		return response()->json($data);
	}

	public function delete(Route $route){
		$route->delete();
        return response()->json(['status' => true]);
	}

}
