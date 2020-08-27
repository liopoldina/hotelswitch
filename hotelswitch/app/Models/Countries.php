<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Countries extends Eloquent
{   
    //    Database connection 
    protected $connection = 'mongodb_static';

    //    The table associated with the model.
    protected $table = 'countries';

    //    The primary key associated with the table.      
    protected $primaryKey = 'code';

}


