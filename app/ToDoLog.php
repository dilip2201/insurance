<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDoLog extends Model
{
	protected $table = 'to_do_logs';
   	protected $fillable = [
        'to_do_id','user_id','status','comment'
    ];
}
