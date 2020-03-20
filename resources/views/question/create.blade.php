@extends('layout.common')
@section('title', '質問投稿画面 - kiqoo')

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content">
	<h2 class="content-header">質問投稿画面</h2>

	<form action="{{ action('QuestionController@create') }}" method="post" enctype="multipart/form-data">
		<div class="form-group row">
			@if($errors->has('title'))
			　　<div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errors->first('title') }}</div>
			@endif
			<label>タイトル</label>
			<input type="text" class="form-control" name="title" value="{{ old('title') }}">
		</div>
		<div class="form-group row">
			@if($errors->has('body'))
			　　<div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errors->first('body') }}</div>
			@endif
			<label>本文</label>
			<textarea class="form-control" name="body" rows="20">{{ old('body') }}</textarea>
		</div>
		<div class="form-group row">
			<label>画像:</label>
			<input type="file" class="form-control-file" name="image_path">
		</div>
		{{ csrf_field() }}
		<input type="submit" class="btn btn-primary" value="更新">
	</form>
</div>
@endsection

@include('layout.footer')