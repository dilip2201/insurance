<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumReport extends Model
{
	protected $table = 'premium_reports';
   	protected $fillable = [
        'due_date','client_id','work_id','company_id','unique_number','amount','status'
    ];
    public function client()
    {
        return $this->belongsTo('App\Client','client_id','id');
    }
    public function work()
    {
        return $this->belongsTo('App\Work','work_id','id');
    }
    public function company()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }
}
