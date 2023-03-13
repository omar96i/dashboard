<?php

namespace App\Http\Controllers\Route;

use App\Http\Controllers\Controller;
use App\Models\Route\Route;
use App\Models\Route\RouteSubcription;
use Illuminate\Http\Request;

class RouteSubscriptionController extends Controller
{
    public function store(Route $route, Request $request){
        $subscription = new RouteSubcription($request->all());
        $subscription->route_id = $route->id;
        $subscription->save();
        return response()->json(['status' => true, 'subscription' => $subscription]);
    }

    public function get(Route $route, $type){

        if($type == 'general'){
            $subscriptions = RouteSubcription::with('created_by.personal_information')->where('route_id', $route->id)->orderBy('start_date', 'desc')->get();
        }else{
            $subscriptions = RouteSubcription::with('created_by.personal_information')->where('status', $type)->where('route_id', $route->id)->orderBy('start_date', 'desc')->get();
        }

        return response()->json([
            'status' => true,
            'subscriptions' => $subscriptions
        ]);
    }

    public function delete(RouteSubcription $subscription){
        $subscription->delete();
        return response(['status' => true]);
    }
}
