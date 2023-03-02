<?php

namespace App\Models\Route;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteSubcription extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'user_id',
        'days',
        'start_date',
        'end_date',
        'price',
        'status'
    ];

    public function route(){
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function created_by(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
