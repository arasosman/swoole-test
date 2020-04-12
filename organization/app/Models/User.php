<?php

namespace App;

use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function profile()
    {
        return $this->hasOne('App\Models\UserProfile');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_user');
    }

    public function distributors()
    {
        return $this->belongsToMany(Organization::class, 'organization_user')->where('type_id', 1);
    }

    public function resellers()
    {
        return $this->belongsToMany(Organization::class, 'organization_user')->where('type_id', 2);
    }

    public function clients()
    {
        return $this->belongsToMany(Organization::class, 'organization_user')->where('type_id', 3);
    }

    public function endusers()
    {
        return $this->belongsToMany(Organization::class, 'organization_user')->where('type_id', 4);
    }
}
