<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientBusiness extends Model
{
	protected $table = 'client_businesses';
   	protected $fillable = [
        'client_id','business_id',
    ];
}
