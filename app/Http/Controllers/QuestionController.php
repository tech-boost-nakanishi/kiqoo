<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Question;

use App\Answer;

use App\User;

use Session;

use App\Picture;

use Storage;

class QuestionController extends Controller
{
	public function index(){
		$questions = Question::orderBy('created_at', 'desc')->paginate(10);
		return view('top', [ 'questions' => $questions ]);
	}

	public function show($id){
		$question = Question::findOrFail($id);

		$answers = $question->answers()->orderBy('created_at', 'desc')->get();
		return view('question.index', ['question' => $question , 'answers' => $answers]);
	}

	public function search(Request $request)
	{
		$keyword = trim($request->keyword);
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

		unset($form['_token']);
		unset($form['image_paths']);
	
		$question->fill($form);
		$question->save();

		if(!empty($request->file('image_paths'))){
			foreach ($request->file('image_paths') as $index => $e) {
				$picture = new Picture;
				$path = Storage::disk('s3')->putFile('/',$e,'public');
				$picture->image_path = Storage::disk('s3')->url($path);
				$picture->question_id = $question->id;
				$picture->save();
			}
		}
	
		return redirect('/question/create')->with('message', '投稿ありがとうございます。');
	}

	public function list()
	{
		$user = Auth::user();
		$questions = $user->questions()->orderBy('created_at', 'desc')->paginate(10);
		return view('question.list', [ 'questions' => $questions ]);
	}

	public function edit($id)
	{
		$question = Question::findOrFail($id);
		if($question->user_id != Auth::user()->id){
			abort(404);
		}
		return view('question.edit', [ 'question' => $question ]);
	}

	public function update(Request $request)
	{
		$this->validate($request, Question::$rules);

		$question = Question::find($request->id);
		$question_form = $request->all();

		unset($question_form['_token']);
		unset($question_form['image_paths']);
		unset($question_form['remove']);
		$question->fill($question_form)->save();

		if(!empty($request->file('image_paths'))){
			foreach ($request->file('image_paths') as $index => $e) {
				$picture = new Picture;
				$path = Storage::disk('s3')->putFile('/',$e,'public');
				$picture->image_path = Storage::disk('s3')->url($path);
				$picture->question_id = $question->id;
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
