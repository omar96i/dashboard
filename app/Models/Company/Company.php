<?php

namespace App\Models\Company;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * Relacion con la tabla pivot "company_membership".
    */
    public function company_membership(){
        return $this->hasMany(CompanyMembership::class, 'company_id');
    }

    /**
     * Relacion con la tabla users.
    */
    public function users(){
        return $this->hasMany(User::class, 'company_id');
    }

}
