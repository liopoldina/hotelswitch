<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Reservation extends Eloquent
{
    // Database connection 
    protected $connection = 'mongodb';


    // Guarded attributes
    protected $guarded = [];


}
