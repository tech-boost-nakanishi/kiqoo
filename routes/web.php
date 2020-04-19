<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'QuestionController@index');

Route::get('/about', function(){
	return view('about');
});

Route::get('/logout', 'HomeController@logout');

Route::get('/register/emailcheck/{email}/{token}', 'Auth\RegisterController@maincheck');

Route::get('/questions/{id}', 'QuestionController@show');

Route::get('/question/search', 'QuestionController@search');

Route::get('/profile/show/{id}', 'ProfileController@show');

Route::get('/list/questions/{id}', 'QuestionController@list');
	
Route::get('/list/answers/{id}', 'AnswerController@list');

Route::get('/ranking', 'RankController@index');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/question/create', 'QuestionController@add');
	Route::post('/question/create', 'QuestionController@create');
	Route::get('/question/edit/{id}', 'QuestionController@edit')->name('question.edit');
	Route::post('/question/edit', 'QuestionController@update');
	Route::get('/question/delete', 'QuestionController@delete');
	Route::get('/answer/delete', 'AnswerController@delete');
	Route::get('/answer/create/{id}', 'AnswerController@add');
	Route::post('/answer/create', 'AnswerController@create');
	Route::get('/answer/edit/{id}', 'AnswerController@edit')->name('answer.edit');
	Route::post('/answer/edit', 'AnswerController@update');
	Route::get('/answer/review/{id}', 'ReviewController@add');
	Route::post('/answer/review', 'ReviewController@update');
	Route::get('/list/unreviews', 'ReviewController@list');
	Route::get('/profile/edit', 'ProfileController@edit');
	Route::post('/profile/edit', 'ProfileController@update');
	Route::get('/cancel', 'HomeController@cancel');
	Route::get('/user/cancel', 'HomeController@delete');
});

Auth::routes();
