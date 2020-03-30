<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Question;

use App\Answer;

use App\User;

use App\Picture;

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
		$this->validate($request, Answer::$rules);

		$answer = new Answer;
		$form = $request->all();
		$answer->user_id = Auth::user()->id;
		$answer->question_id = $request->question_id;
	
		unset($form['_token']);
		unset($form['image_paths']);
	
		$answer->fill($form);
		$answer->save();

		foreach ($request->file('image_paths') as $index => $e) {
			$picture = new Picture;
			$path = Storage::disk('s3')->putFile('/',$e,'public');
			$picture->image_path = Storage::disk('s3')->url($path);
			$picture->answer_id = $answer->id;
			$picture->save();
		}
	
		return redirect('/answer/create/'.$answer->question_id)->with('message', '回答ありがとうございます。');
    }

    public function list()
	{
		$user = Auth::user();
		$answers = $user->answers()->orderBy('created_at', 'desc')->paginate(10);
		return view('answer.list', [ 'answers' => $answers ]);
	}

	public function edit($id)
	{
		$answer = Answer::findOrFail($id);
		if($answer->user_id != Auth::user()->id){
			abort(404);
		}
		$question = Question::find($answer->question_id);
		$user = User::find($question->user_id);
		return view('answer.edit', ['answer' => $answer , 'question' => $question , 'user' => $user]);
	}

	public function update(Request $request)
	{
		$this->validate($request, Answer::$rules);

		$answer = Answer::find($request->id);
		$answer_form = $request->all();

		foreach ($request->remove as $key => $value) {
			$image = Picture::find($value);
			$image_path = explode("/", $image->image_path);
			$img = end($image_path);
			$disk = Storage::disk('s3');
			$disk->delete($img);
			$image->delete();
		}

		unset($answer_form['_token']);
		unset($answer_form['remove']);
		$answer->fill($answer_form)->save();

		foreach ($request->file('image_paths') as $index => $e) {
			$picture = new Picture;
			$path = Storage::disk('s3')->putFile('/',$e,'public');
			$picture->image_path = Storage::disk('s3')->url($path);
			$picture->answer_id = $answer->id;
			$picture->save();
			unset($answer_form['image_paths']);
		}

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
