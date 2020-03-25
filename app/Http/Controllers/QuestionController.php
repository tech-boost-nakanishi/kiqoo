<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Question;

use App\Answer;

use App\User;

use Storage;

class QuestionController extends Controller
{
	public function index(){
		$questions = Question::orderBy('created_at', 'desc')->paginate(10);
		return view('top', [ 'questions' => $questions ]);
	}

	public function show($id){
		$question = Question::findOrFail($id);
		$user_id = $question->user_id;
		$user = User::find($user_id);

		$answers = Answer::where('question_id', $id)->orderBy('created_at', 'desc')->get();
		$answers_count = count($answers);
		$answer_user = array();
		foreach ($answers as $answer) {
			$users = User::find($answer->user_id);
			$answer_user[] = $users;
		}
		return view('question.index', ['question' => $question , 'user' => $user , 'answers' => $answers , 'answers_count' => $answers_count , 'answer_user' => $answer_user]);
	}

	public function search(Request $request)
	{
		$keyword = $request->keyword;
		// if(empty($keyword)){
		// 	$keyword = "%20";
		// }
		return redirect('/questions/search/keyword/' . $keyword);
	}

	public function searchresult($keyword)
	{
		$keyword = $keyword;
		return view('question.search', ['keyword' => $keyword]);
	}

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

	public function list()
	{
		$user_id = Auth::user()->id;
		$questions = Question::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(10);
		return view('question.list', [ 'questions' => $questions ]);
	}

	public function edit($id)
	{
		$question = Question::findOrFail($id);
		if($question->user_id != Auth::user()->id){
			//abort(404);
		}
		return view('question.edit', [ 'question' => $question ]);
	}

	public function update(Request $request)
	{
		$this->validate($request, Question::$rules);

		$question = Question::find($request->id);
		$question_form = $request->all();
		if (isset($question_form['image_path'])) {
			$path = Storage::disk('s3')->putFile('/',$question_form['image_path'],'public');
			$question->image_path = Storage::disk('s3')->url($path);
			unset($question_form['image_path']);
		} elseif (isset($request->remove)) {
			$image = $question->image_path;
			$image = explode("/", $image);
			$img = end($image);
			$disk = Storage::disk('s3');
			$disk->delete($img);
			$question->image_path = null;
			unset($question_form['remove']);
		}
		unset($question_form['_token']);
		$question->fill($question_form)->save();

		return redirect('/list/questions')->with('questionedit', '投稿を変更しました。');
	}

	public function delete(Request $request)
	{
		$question = Question::find($request->id);
		$image = $question->image_path;
		$image = explode("/", $image);
		$img = end($image);
		$disk = Storage::disk('s3');
		$disk->delete($img);
		$question->delete();
		return redirect('/list/questions')->with('questiondelete', '投稿を削除しました。');
	}
}
