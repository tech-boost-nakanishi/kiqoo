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
}
