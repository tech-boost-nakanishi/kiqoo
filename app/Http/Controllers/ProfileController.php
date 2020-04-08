<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use App\Review;

use Storage;

class ProfileController extends Controller
{
    public function show($id)
    {
    	$user = User::findOrFail($id);
    	$answers = $user->answers()->get();
    	$reviews = [];
    	foreach ($answers as $answer) {
    		$review[] = Review::where('answer_id', $answer->id)->whereNotNull('review')->first();
    	}
    	if(empty($reviews)){
    		$review_avg = 0;
    	}elseif(count($reviews) == 1){
    		$review_avg = $reviews[0];
    	}else{
    		$review_avg = $reviews->avg();
    	}
    	$review_avg = round($review_avg);
    	$review_percent = round($review_avg / 5 * 100, 1);
    	return view('profile.index', ['user' => $user , 'review_avg' => $review_avg , 'review_percent' => $review_percent]);
    }

    public function edit()
    {
    	return view('profile.edit');
    }

    public function update(Request $request)
    {
    	$user_id = Auth::user()->id;
    	$user = User::find($user_id);
    	$form = $request->all();

    	if(!empty($request->qualification)){
    		$user->qualification = str_replace('／', '/', $request->qualification);
    	}else{
    		$user->qualification = null;
    	}

    	if(!empty($request->hobby)){
    		$user->hobby = str_replace('／', '/', $request->hobby);
    	}else{
    		$user->hobby = null;
    	}

    	if(!empty($request->introduction)){
    		$user->introduction = $request->introduction;
    	}else{
    		$user->introduction = null;
    	}

    	if(!empty($request->file('image_path'))){
    		$image = explode("/", $user->image_path);
    		$img = end($image);
    		if($img != "BIkd1g42sDeFjUxxXr5ydLfOBSBNMxQffv6xT7xX.jpeg"){
    			$disk = Storage::disk('s3');
				$disk->delete($img);
    		}
    		$path = Storage::disk('s3')->putFile('/',$request->file('image_path'),'public');
			$user->image_path = Storage::disk('s3')->url($path);
    	}

    	unset($form['_token']);
		unset($form['image_path']);
		$user->save();

		return redirect('/profile/edit')->with('profileedit', 'プロフィールを更新しました。');
    }
}
