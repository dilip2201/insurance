<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
	protected $table = 'businesses';
   	protected $fillable = [
        'name'
    ];

    public function clients()
    {
        return $this->belongsToMany('App\Client','client_businesses','business_id','client_id');
    }
}
