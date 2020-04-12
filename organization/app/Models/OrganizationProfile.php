<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    protected $fillable = [
        'organization_id',
        'staff',
        'email',
        'phone',
        'gsm_phone',
        'fax',
        'address',
        'tax_administration',
        'tax_no',
        'logo'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
