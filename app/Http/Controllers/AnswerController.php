<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Question;

use App\Answer;

use App\User;

use Storage;

class AnswerController extends Controller
{
    public function add($id)
    {
    	$question = Question::findOrFail($id);
    	$user_id = $question->user_id;
		$user = User::find($user_id);
    	return view('answer.create', ['question' => $question, 'user' => $user]);
    }

    public function create(Request $request)
	{
		//$this->validate($request, Answer::$rules);

		$answer = new Answer;
		$form = $request->all();
		$answer->user_id = Auth::user()->id;
		$answer->question_id = $request->question_id;

		if (isset($form['image_path'])) {
			$path = Storage::disk('s3')->putFile('/',$form['image_path'],'public');
			$answer->image_path = Storage::disk('s3')->url($path);
		} else {
			$answer->image_path = null;
		}
	
		unset($form['_token']);
		unset($form['image_path']);
	
		$answer->fill($form);
		$answer->save();
	
		return redirect('/answer/create/'.$answer->question_id)->with('message', '回答ありがとうございます。');
    }

    public function list()
	{
		$user_id = Auth::user()->id;
		$answers = Answer::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(10);
		return view('answer.list', [ 'answers' => $answers ]);
	}

	public function edit($id)
	{
		$answer = Answer::findOrFail($id);
		$question = Question::find($answer->question_id);
		$user = User::find($question->user_id);
		return view('answer.edit', ['answer' => $answer , 'question' => $question , 'user' => $user]);
	}

	public function update(Request $request)
	{
		$this->validate($request, Answer::$rules);

		$answer = Answer::find($request->id);
		$answer_form = $request->all();
		if (isset($answer_form['image_path'])) {
			$path = Storage::disk('s3')->putFile('/',$answer_form['image_path'],'public');
			$answer->image_path = Storage::disk('s3')->url($path);
			unset($answer_form['image_path']);
		} elseif (isset($request->remove)) {
			$image = $answer->image_path;
			$image = explode("/", $image);
			$img = end($image);
			$disk = Storage::disk('s3');
			$disk->delete($img);
			$answer->image_path = null;
			unset($answer_form['remove']);
		}
		unset($answer_form['_token']);
		$answer->fill($answer_form)->save();

		return redirect('/list/answers')->with('answeredit', '投稿を変更しました。');
	}

	public function delete(Request $request)
	{
		$answer = Answer::find($request->id);
		$image = $answer->image_path;
		$image = explode("/", $image);
		$img = end($image);
		$disk = Storage::disk('s3');
		$disk->delete($img);
		$answer->delete();
		return redirect('/list/answers')->with('answerdelete', '回答を削除しました。');
	}
}
