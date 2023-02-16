<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $table = 'personal_information';

    protected $fillable = [
        'id_card',
        'user_id',
        'full_name',
        'address',
        'landline',
        'country_code',
        'iso',
        'phone',
        'city',
        'department',
    ];

    // Relations

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }




}
