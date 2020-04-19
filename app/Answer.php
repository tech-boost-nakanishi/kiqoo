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

	public function review()
	{
		return $this->hasOne("App\Review");
	}

	public static function boot() 
	{
	    parent::boot();
	    static::deleting(function($answer) {
	        $answer->review()->delete();

	        foreach ($answer->pictures()->get() as $child) {
	            $child->delete();
	        }
	    });
	}
}
