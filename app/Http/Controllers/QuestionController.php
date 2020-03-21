<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Question;

use Storage;

class QuestionController extends Controller
{
	public function add()
	{
		return view('question.create');
	}

	public function create(Request $request)
	{
		$this->validate($request, Question::$rules);
	
		$question = new Question;
		$form = $request->all();
		$question->user_id = Auth::user()->id;

		if (isset($form['image_path'])) {
			$path = Storage::disk('s3')->putFile('/',$form['image_path'],'public');
			$question->image_path = Storage::disk('s3')->url($path);
		} else {
			$question->image_path = null;
		}
	
		unset($form['_token']);
		unset($form['image_path']);
	
		$question->fill($form);
		$question->save();
	
		return redirect('/question/create')->with('message', '投稿ありがとうございます。');
	}
}
