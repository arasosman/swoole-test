<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $table = "tutorials";

    protected $fillable = ['title', 'description'];
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}
