<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Answer;

use App\Review;

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

    public function update(Request $request)
    {
    	$this->validate($request, Review::$rules);

    	$review = Review::where('answer_id', $request->answer_id);
    	dd($review);
    	$review->review = $request->review;
    	$form = $request->all();

    	unset($form['_token']);
    	unset($form['review']);
    	$review->save();

    	return redirect('/answer/review/' . $request->answer_id)->with('review', '評価を受け付けました。');
    }
}
