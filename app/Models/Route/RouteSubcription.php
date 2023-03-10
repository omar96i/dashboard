<?php

namespace App\Models\Route;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class RouteSubcription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'route_id',
        'created_by',
        'days',
        'start_date',
        'end_date',
        'price',
        'status',
        'user_deleted_id'
    ];

    public function route(){
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function created_by(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userDeleted()
    {
        return $this->belongsTo(User::class, 'user_deleted_id');
    }

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->user_deleted_id = auth()->check() ? auth()->user()->id : null;
            $model->save();
        });
    }
}
