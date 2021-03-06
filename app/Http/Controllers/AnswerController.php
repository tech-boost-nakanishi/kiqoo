<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewMail;

use App\Question;

use App\Answer;

use App\User;

use App\Picture;

use App\Review;

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
		$answer->body = $request->body;
	
		$answer->save();

		if(!empty($request->file('image_paths'))){
			foreach ($request->file('image_paths') as $index => $e) {
				$picture = new Picture;
				$path = Storage::disk('s3')->putFile('/',$e,'public');
				$picture->image_path = Storage::disk('s3')->url($path);
				$picture->answer_id = $answer->id;
				$picture->save();
			}
		}

		unset($form['_token']);
		unset($form['image_paths']);

		if(!empty($request->question_user_id)){
			$review = new Review;
			$review->answer_id = $answer->id;
			$review->question_user_id = $request->question_user_id;
			$review->save();
		}
		$user = User::find($request->question_user_id);
		$question = $answer->question()->first();
		Mail::to($user->email)
		->send(new ReviewMail(
			$name = $user->name,
			$question_id = $question->id,
			$question_title = $question->title,
			$answer_id = $answer->id
		));

		return redirect('/list/answers/' . Auth::user()->id)->with('message', '回答ありがとうございます。');
    }

    public function list($id)
	{
		$user = User::findOrFail($id);
		$answers = $user->answers()->orderBy('created_at', 'desc')->paginate(5);
		return view('answer.list', [ 'answers' => $answers , 'user' => $user ]);
	}

	public function edit($id)
	{
		$answer = Answer::findOrFail($id);
		if($answer->user_id != Auth::user()->id){
			abort(404);
		}
		return view('answer.edit', ['answer' => $answer]);
	}

	public function update(Request $request)
	{
		$this->validate($request, Answer::$rules);

		$answer = Answer::find($request->id);
		$answer_form = $request->all();

		unset($answer_form['_token']);
		unset($answer_form['image_paths']);
		unset($answer_form['remove']);
		$answer->fill($answer_form)->save();

		if(!empty($request->file('image_paths'))){
			foreach ($request->file('image_paths') as $index => $e) {
				$picture = new Picture;
				$path = Storage::disk('s3')->putFile('/',$e,'public');
				$picture->image_path = Storage::disk('s3')->url($path);
				$picture->answer_id = $answer->id;
				$picture->save();
			}
		}

		if(!empty($request->remove)){
			foreach ($request->remove as $key => $value) {
				$image = Picture::find($value);
				$image_path = explode("/", $image->image_path);
				$img = end($image_path);
				$disk = Storage::disk('s3');
				$disk->delete($img);
				$image->delete();
			}
		}

		return redirect('/list/answers/' . Auth::user()->id)->with('answeredit', '投稿を変更しました。');
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
		return redirect('/list/answers/' . Auth::user()->id)->with('answerdelete', '回答を削除しました。');
	}
}
