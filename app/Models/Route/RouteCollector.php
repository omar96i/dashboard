<?php

namespace App\Models\Route;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteCollector extends Model
{
    use HasFactory;

    protected $fillable = [
        'collector_id',
        'route_id',
        'status'
    ];

    public function collector(){
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function route(){
        return $this->belongsTo(Route::class, 'route_id');
    }
}
