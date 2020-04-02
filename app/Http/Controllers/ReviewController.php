<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Answer;

class ReviewController extends Controller
{
    public function add($id)
    {
    	$answer = Answer::findOrFail($id);
    	if(!empty($answer->question()->user_id)){
	    	if(Auth::user()->id != $answer->question()->user_id){
	    		abort(404);
	    	}
	    }

    	return view('review.create', ['answer' => $answer]);
    }
}
