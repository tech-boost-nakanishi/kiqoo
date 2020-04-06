<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Question;

use App\Answer;

use App\User;

use Session;

use App\Picture;

use Storage;

class QuestionController extends Controller
{
	public function index(Request $request){
		$questions = Question::orderBy('created_at', 'desc')->paginate(10);
		//dd($questions);
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
		$keyword = mb_convert_kana($keyword, 's');
		$question = Question::all();
		$result = [];
		$questions = [];
		$from = 0;
		$to = 0;
		if(!empty($keyword)){
			$keyword = explode(" ", $keyword);
			foreach ($keyword as $key => $value) {
				foreach ($question as $ques) {
					if(preg_match("/{$value}/ium", $ques->title) > 0){
						if(preg_match("/{$value}/ium", $ques->body) > 0){
							$ques->title = preg_replace("/" . preg_quote($value) . "/ium", "<span style=\"font-weight: bold;\">\\0</span>", $ques->title);
							$ques->body = preg_replace("/" . preg_quote($value) . "/ium", "<span style=\"font-weight: bold;\">\\0</span>", $ques->body);
							$result[] = $ques;
						}else{
							$ques->title = preg_replace("/" . preg_quote($value) . "/ium", "<span style=\"font-weight: bold;\">\\0</span>", $ques->title);
							$result[] = $ques;
						}
					}else{
						if(preg_match("/{$value}/ium", $ques->body) > 0){
							$ques->body = preg_replace("/" . preg_quote($value) . "/ium", "<span style=\"font-weight: bold;\">\\0</span>", $ques->body);
							$result[] = $ques;
						}
					}
				}
			}
			$id = [];
			foreach ($result as $key => $value) {
				if(!in_array($value['id'], $id)){
					$id[] = $value['id'];
					$questions[] = $value;
				}
			}
			$sort = [];
			foreach ($questions as $key => $value) {
				$sort[$key] = $value['created_at'];
			}
			array_multisort($sort, SORT_DESC, $questions);
			if(count($questions) > 0){
				$PerPage = 10;   //1ページあたりの件数
				$displayData = array_chunk($questions, $PerPage);
		        $currentPageNo = $request->input('page', 1);

		        $pagination = new LengthAwarePaginator(
		            $displayData[$currentPageNo - 1],
		            count($questions),
		            $PerPage,
		            $currentPageNo,
		            array('path' => $request->url())
		        );

		        if($request->input('page', 1) * $PerPage - $PerPage + 1 < count($questions)){
		        	$from = $request->input('page', 1) * $PerPage - $PerPage + 1;
		        }else{
		        	$from = count($questions);
		        }

		        if($from + $PerPage - 1 < count($questions)){
		        	$to = $from + $PerPage - 1;
		        }else{
		        	$to = count($questions);
		        }
			}else{
				$pagination = 0;
			}
		}else{
			$pagination = 0;
		}
		return view('question.search', ['keyword' => $request->keyword , 'questions' => $questions , 'pagination' => $pagination , 'from' => $from , 'to' => $to]);
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
