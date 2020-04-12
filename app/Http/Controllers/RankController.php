<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;

use App\User;

use App\Question;

class RankController extends Controller
{
    public function index(Request $request)
    {
    	$result = [];
    	$sort = [];
    	$pagination = 0;

    	if(isset($request->sortby)){
	    	if($request->sortby == "manyquestions" || $request->sortby == "manyanswers" || $request->sortby == "highreviews"){
	    		$users = User::get(["id", "name"]);
	    		foreach ($users as $key => $value) {
	    			$questions = $value->questions()->get();
	    			$value->questions = count($questions);

	    			$answers = $value->answers()->get();
	    			$value->answers = count($answers);

	    			$reviews = [];
	    			$sum = 0;
			    	$count = 0;
			    	if(count($answers) > 0){
			    		foreach ($answers as $answer) {
				            $reviews[] = $answer->review()->first();
				    	}
			    	}
			    	if(count($reviews) == 0){
			    		$review_avg = 0;
			    		$review_percent = 0;
			    	}else{
			    		foreach ($reviews as $key => $review) {
			                if(!is_null($review->review)){
			                    $sum += $review->review;
			                    $count++;
			                }
			    		}
			    		$review_avg = $sum / $count;
			    		$review_percent = round(round($review_avg, 1) / 5 * 100, 1);
			    	}
			    	$value->review_avg = $review_avg;
			    	$value->review_percent = $review_percent;

			    	if($request->sortby == "manyquestions"){
			    		$sort[$key] = $value->questions;
			    	}elseif($request->sortby == "manyanswers"){
			    		$sort[$key] = $value->answers;
			    	}elseif($request->sortby == "highreviews"){
			    		$sort[$key] = $value->review_avg;
			    	}
	    			

	    			$result[] = $value;
	    		}
	    		array_multisort($sort, SORT_DESC, $result);
	    	}elseif($request->sortby == "manyviewsquestion"){
	    		$questions = Question::all();
	    		foreach ($questions as $key => $value) {
	    			$view = $value->view()->first();
	    			$value->view = $view->view;

	    			$sort[$key] = $value->view;

	    			$result[] = $value;
	    		}
	    		array_multisort($sort, SORT_DESC, $result);
	    	}


	    	if(count($result) > 0){
				$PerPage = 1;   //1ページあたりの件数
				$displayData = array_chunk((array)$result, $PerPage);
		        $currentPageNo = $request->input('page', 1);

		        $pagination = new LengthAwarePaginator(
		            $displayData[$currentPageNo - 1],
		            count($result),
		            $PerPage,
		            $currentPageNo,
		            array('path' => $request->url())
		        );
			}
    	}
    	return view('ranking', ['result' => $result , 'pagination' => $pagination]);
    }
}
