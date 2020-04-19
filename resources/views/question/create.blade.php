@extends('layout.common')
@section('title', '質問投稿画面 - ' . $appname)

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content col-md-8 col-xs-12">
	<h2 class="content-header">質問投稿画面</h2>

	@if(session('message'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('message') }}</div>
	@endif
	<div class="container">
		<form action="{{ action('QuestionController@create') }}" method="post" enctype="multipart/form-data">
			<div class="form-group row">
				@if($errors->has('title'))
				　　<div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errors->first('title') }}</div>
				@endif
				<label>タイトル</label>
				<input type="text" class="form-control" name="title" placeholder="タイトルを入力してください" value="{{ old('title') }}">
			</div>
			<div class="form-group row">
				@if($errors->has('body'))
				　　<div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errors->first('body') }}</div>
				@endif
				<label>本文</label>
				<textarea class="form-control" name="body" rows="15" placeholder="質問文を入力してください">{{ old('body') }}</textarea>
			</div>
			<div class="form-group row">
				<label>画像:</label>
				<input type="file" class="form-control-file" name="image_paths[]" multiple>
			</div>
			{{ csrf_field() }}
			<input type="submit" class="btn btn-primary" value="投稿">
		</form>
	</div>
</div>
@endsection

@include('layout.footer')