<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
	protected $table = 'todos';
   	protected $fillable = [
        'date','task_name','description','due_date','remarks','work_alloted','status'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','work_alloted_id','id');
    }
}
