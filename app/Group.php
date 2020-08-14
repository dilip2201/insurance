<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $table = 'groups';
   	protected $fillable = [
        'name'
    ];

    public function clients()
    {
    	return $this->hasMany('App\Client','group_id','id');
    }

}
