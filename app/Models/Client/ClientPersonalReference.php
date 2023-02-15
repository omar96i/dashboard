<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPersonalReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'full_name',
        'country_code',
        'phone',
        'address'
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }


}
