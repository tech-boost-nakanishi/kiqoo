<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $guarded = array('id');

	public static $rules = array(
		'title' => 'required|max:100',
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

	public function answers()
	{
		return $this->hasMany("App\Answer");
	}

	public function view()
	{
		return $this->hasOne("App\View");
	}

	public static function boot() 
	{
	    parent::boot();
	    static::deleting(function($question) {
	        $question->view()->delete();

	        foreach ($question->pictures()->get() as $child) {
	            $child->delete();
	        }

	        foreach ($question->answers()->get() as $child) {
	            $child->delete();
	        }
	    });
	}
}
