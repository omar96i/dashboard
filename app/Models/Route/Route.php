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
        'start_date',
        'end_date',
        'status'
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
}
