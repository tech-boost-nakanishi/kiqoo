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
}
