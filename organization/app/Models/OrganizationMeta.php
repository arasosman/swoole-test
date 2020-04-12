<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationMeta extends Model
{
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
