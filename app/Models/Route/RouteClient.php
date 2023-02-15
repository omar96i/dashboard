<?php

namespace App\Models\Route;

use App\Models\Client\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'client_id',
        'status',
        'priority'
    ];

    public function route(){
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }
}
