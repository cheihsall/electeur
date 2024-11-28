<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class recencer extends Model
{
    
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'recencers';
}
