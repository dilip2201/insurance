<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
	protected $table = 'works';
   	protected $fillable = [
        'client_id','work','company_id','unique_number','amount','start_date','end_date','period','status'
    ];
    public function client()
    {
        return $this->belongsTo('App\Client','client_id','id');
    }
    public function company()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }
}
