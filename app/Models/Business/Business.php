<?php

namespace App\Models\Business;

use App\Models\Route\Route;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'business';

    protected $fillable = [
        'name',
        'country',
        'time_zone',
        'path_icon',
        'description'
    ];

    public function users(){
        return $this->hasMany(User::class, 'business_id');
    }

    public function routes(){
        return $this->hasMany(Route::class, 'business_id');
    }

    public function clients(){
        return $this->hasMany(BusinessClient::class, 'business_id');
    }
}
