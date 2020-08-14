<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $table = 'clients';
   	protected $fillable = [
        'group_id','name_salutation', 'first_name', 'last_name','relation','group_head','date_of_birth','date_of_anniversary','mobile_number','email','address_1','address_2','area','city','pin_code','client_category','status'
    ];
    public function group()
    {
        return $this->belongsTo('App\Group','group_id','id');
    }

    public function business()
    {
        return $this->belongsToMany('App\Business','client_businesses','client_id','business_id');
    }

    public function work()
    {
        return $this->belongsTo('App\Work','id','client_id');
    }
}
