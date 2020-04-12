<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['user_id', 'phone', 'avatar'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
