<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumLog extends Model
{
	protected $table = 'premium_logs';
   	protected $fillable = [
        'premium_report_id','user_id','status','comment','next_followup_date'
    ];

}
