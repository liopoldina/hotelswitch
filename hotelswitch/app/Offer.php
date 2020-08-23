<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Offer extends Eloquent
{   
    //    Database connection 
    protected $connection = 'hotelbeds';

    //    The table associated with the model.
    protected $table = '38.712526349309_-9.1384437715424_2020-08-22_2020-08-23_1_2_2';

    //    The primary key associated with the table.      
    protected $primaryKey = 'code';

    //    Timestamps 
    const UPDATED_AT = 'lastUpdate'; // customize colum name
    protected $dateFormat = 'Y-m-d'; // customize timestamp format

}
