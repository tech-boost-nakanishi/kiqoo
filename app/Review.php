<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'question_user_id' => 'required',
        'answer_id' => 'required',
        'review' => 'required',
    );

    public function answer()
    {
        return $this->belongsTo("App\Answer");
    }
}
