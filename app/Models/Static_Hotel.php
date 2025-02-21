<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Static_Hotel extends Eloquent
{   
    //    Database connection 
    protected $connection = 'mongodb_static';

    //    The table associated with the model.
    protected $table = 'hotels';

    //    The primary key associated with the table.      
    protected $primaryKey = 'code';
    protected $keyType = 'int';

    //    Timestamps 
    const UPDATED_AT = 'lastUpdate'; // customize colum name
    protected $dateFormat = 'Y-m-d'; // customize timestamp format

    //    Relationships
    public function country(){
        return $this->hasOne(Country::class,'code','countryCode');

    }

}


