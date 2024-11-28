<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Admin extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'admins';

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
}
