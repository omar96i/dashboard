<?php

namespace App\Http\Controllers\Route;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route\Route;
use App\Models\Route\RouteCollector;
use App\Models\Business\Business;
use Illuminate\Support\Facades\DB;
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

	public function get(Request $request){
		if (auth()->user()->roles->pluck('name')[0] == 'super.admin') {
            // Filtros
            if(isset($request->subcription)){
                if($request->subcription){
                    $routes = Route::whereHas('subscriptions', function($query){
                        $query->latest()->where('status', 'active');
                    })->get();
                }else{
                    $routes = Route::where(function ($query) {
                        $query->whereDoesntHave('subscriptions')
                              ->orWhereHas('subscriptions', function ($subquery) {
                                  $subquery->where('created_at', function ($createdQuery) {
                                      $createdQuery->from('route_subcriptions')
                                                   ->selectRaw('MAX(created_at)')
                                                   ->whereColumn('route_id', 'routes.id');
                                  })->where('status', 'inactive');
                              });
                    })->get();
                }
            }else{
            	$routes = Route::get();
            }
            if($request->business_id){
                $routes->where('business_id', $request->business_id);
            }
            if($request->route){
                $routes->where('name', 'LIKE', '%'.$request->route.'%');
            }
            $routes->load(['subscriptions' => function ($query) {
                $query->orderBy('start_date', 'desc');
            }, 'subscriptions.created_by.personal_information', 'business']);
            // EndFiltros

			$data = [
						'status'=>true,
						'routes'=>$routes,
						'business'=>Business::get()
				    ];
			return response()->json($data);
        }else if(auth()->user()->roles->pluck('name')[0] == 'admin'){
            $routes = Route::select(['*', DB::raw('(CASE
                    WHEN EXISTS (SELECT 1 FROM route_subcriptions WHERE route_id = routes.id AND status = "active")
                    THEN "active"
                    WHEN NOT EXISTS (SELECT 1 FROM route_subcriptions WHERE route_id = routes.id) OR EXISTS (SELECT 1 FROM route_subcriptions WHERE route_id = routes.id AND status = "inactive")
                    THEN "inactive"
                    ELSE "unknown"
                END) AS status')])
            ->where('business_id', auth()->user()->business_id)
            ->get();
            if($request->route){
                $routes->where('name', 'LIKE', '%'.$request->route.'%');
            }

            $routes->load(['subscriptions' => function ($query) {
                $query->orderBy('start_date', 'desc');
            }, 'subscriptions.created_by.personal_information', 'business', 'route_collector.collector.personal_information']);

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
