<?php

namespace App\Models\Business;

use App\Models\Client\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'client_id',
        'status',
    ];

    public function business(){
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }
}
