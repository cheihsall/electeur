<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
// use Jenssegers\Mongodb\Eloquent\Model;




class Young extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'youngs';

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'id_card_number',
        'is_elector',
        'phone',
        'email',
        'address',
        'documents',
        'admin_id',
    ];
}
