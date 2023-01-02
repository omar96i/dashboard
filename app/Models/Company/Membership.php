<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost',
        'status',
    ];

    /**
     * Relacion con la tabla pivot "company_membership".
    */
    public function company_membership(){
        return $this->hasMany(CompanyMembership::class, 'membership_id');
    }

}
