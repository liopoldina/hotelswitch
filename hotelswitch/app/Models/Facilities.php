<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Facilities extends Eloquent
{   
    //    Database connection 
    protected $connection = 'mongodb_modified_static';

    //    The table associated with the model.
    protected $table = 'facilities';
}


