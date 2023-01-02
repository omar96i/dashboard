<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'membership_id',
        'status',
    ];

    /**
     * Relacion con la tabla companies.
    */
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Relacion con la tabla memberships.
    */
    public function membership(){
        return $this->belongsTo(Membership::class, 'membership_id');
    }

}
