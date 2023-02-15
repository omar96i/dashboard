<?php

namespace App\Models\Client;

use App\Models\Business\BusinessClient;
use App\Models\Route\RouteClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_card',
        'full_name',
        'address_billing',
        'address',
        'landline',
        'country_code',
        'phone',
        'neighbothood',
        'description_business',
        'address_business',
        'phone_business',
        'email',
    ];

    public function business(){
        return $this->hasMany(BusinessClient::class, 'client_id');
    }

    public function routes(){
        return $this->hasMany(RouteClient::class, 'client_id');
    }

    public function personal_references(){
        return $this->hasMany(ClientPersonalReference::class, 'client_id');
    }

    public function guarantors(){
        return $this->hasMany(ClientGuarantor::class, 'client_id');
    }

}
