<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Reservation extends Eloquent
{
    // Database connection 
    protected $connection = 'mongodb';

    // Primary Key
    protected $primaryKey = 'id';

    // Guarded attributes
    protected $guarded = [];


}
