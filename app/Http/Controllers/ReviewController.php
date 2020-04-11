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
    	$question = $answer->question()->first();
    	if(Auth::user()->id != $question->user_id){
    		abort(404);
    	}

    	return view('review.create', ['answer' => $answer]);
    }

    public function update(Request $request)
    {
    	$this->validate($request, Review::$rules);

    	$review = Review::where('answer_id', $request->answer_id)->first();
        if($review->review == null){
            $review->question_user_id = $request->question_user_id;
            $review->answer_id = $request->answer_id;
            $review->review = $request->review;
            $form = $request->all();

            unset($form['_token']);
            unset($form['review']);
            $review->save();

            return redirect('/answer/review/' . $request->answer_id)->with('review', '評価を受け付けました。');
        }else{
            return redirect('/answer/review/' . $request->answer_id)->with('reviewed', 'すでに評価済です。');
        }
    	
    }

    public function list()
    {
        $unreviews = Review::where('question_user_id', Auth::user()->id)->whereNull('review')->orderBy('created_at', 'desc')->get();
        $answers = [];
        foreach ($unreviews as $unreview) {
            $answers[] = $unreview->answer()->first();
        }
        return view('review.list', ['answers' => $answers]);
    }
}
