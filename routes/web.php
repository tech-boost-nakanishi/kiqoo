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

Route::get('/logout', 'HomeController@logout');

Route::get('/questions/{id}', 'QuestionController@show');

Route::get('*', 'QuestionController@search');

Route::get('/questions/search/keyword/{keyword}', 'QuestionController@searchresult');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/question/create', 'QuestionController@add');
	Route::post('/question/create', 'QuestionController@create');
	Route::get('/question/edit/{id}', 'QuestionController@edit')->name('question.edit');
	Route::post('/question/edit', 'QuestionController@update');
	Route::get('/question/delete', 'QuestionController@delete');
	Route::get('/answer/delete', 'AnswerController@delete');
	Route::get('/answer/create/{id}', 'AnswerController@add');
	Route::post('/answer/create', 'AnswerController@create');
	Route::get('/list/questions', 'QuestionController@list');
	Route::get('/list/answers', 'AnswerController@list');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
