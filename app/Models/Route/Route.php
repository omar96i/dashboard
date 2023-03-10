<?php

namespace App\Models\Route;

use App\Models\Business\Business;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;


    protected $fillable = [
        'business_id',
        'name',
    ];

    public function business(){
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function route_collector(){
        return $this->hasMany(RouteCollector::class, 'route_id');
    }

    public function clients(){
        return $this->hasMany(RouteClient::class, 'client_id');
    }

    public function subscriptions(){
        return $this->hasMany(RouteSubcription::class, 'route_id');
    }

    public static function getRoutesBySubcription($flag, $business_id, $route){
        if(!empty($flag)){
            if($flag){
                return self::whereHas('subscriptions', function($query){
                    $query->where('status', 'active');
                })->where('business_id', $business_id)->where('name','LIKE','%'.$route.'%')->with('business', 'route_collector.collector.personal_information')->get();
            }else{
                return self::where('business_id', $business_id)->where('name','LIKE','%'.$route.'%')->orWhereHas('subscriptions', function($query){
                    $query->latest()->where('status', 'inactive');
                })->with('business', 'route_collector.collector.personal_information')->get();
            }
        }
        return self::where('business_id', $business_id)->where('name','LIKE','%'.$route.'%')->with('business', 'route_collector.collector.personal_information')->get();
    }
}
