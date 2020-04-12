<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'type_id', 'parent_id', 'status', 'created_by'];

    public function parent()
    {
        return $this->belongsTo(Organization::class, 'parent_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function profile()
    {
        return $this->hasOne(OrganizationProfile::class);
    }

    public function type()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function metas()
    {
        return $this->hasMany(OrganizationMeta::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user');
    }
}
