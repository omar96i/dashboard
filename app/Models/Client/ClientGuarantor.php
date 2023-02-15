<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGuarantor extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'full_name',
        'country_code',
        'phone',
        'landline',
        'address',
        'address_business',
        'phone_business'
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }

}
