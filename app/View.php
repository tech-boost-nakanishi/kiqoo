<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $guarded = array('id');

    // public static $rules = array(
    //     'question_id' => 'required',
    // );

    public function question()
    {
    	return $this->belongsTo("App\Question");
    }
}
