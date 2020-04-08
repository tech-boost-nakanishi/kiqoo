<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'question_id' => 'required',
        'body' => 'required|max:1000',
    );

    public function pictures()
	{
		return $this->hasMany("App\Picture");
	}

    public function user()
	{
		return $this->belongsTo("App\User");
	}

	public function question()
	{
		return $this->belongsTo("App\Question");
	}

	public function reviews()
	{
		return $this->hasMany("App\Review");
	}
}
