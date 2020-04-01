@extends('layout.common')
@section('title', '質問編集画面 - kiqoo')

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content">
	<h2 class="content-header">質問編集画面</h2>

	<form action="{{ action('QuestionController@update') }}" method="post" enctype="multipart/form-data">
		<div class="form-group row">
			@if($errors->has('title'))
			　　<div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errors->first('title') }}</div>
			@endif
			<label>タイトル</label>
			<input type="text" class="form-control" name="title" value="{{ $question->title }}">
		</div>
		<div class="form-group row">
			@if($errors->has('body'))
			　　<div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errors->first('body') }}</div>
			@endif
			<label>本文</label>
			<textarea class="form-control" name="body" rows="15">{{ $question->body }}</textarea>
		</div>
		<div class="form-group row">
			<label>画像:</label>
			<input type="file" class="form-control-file" name="image_paths[]" multiple>
		</div>
		<div class="form-group row">
			<label style="position: absolute;">設定中の画像の削除（複数選択可）</label><br>
			<hr style="width: 100%; margin-top: 30px;">
			@if(count($question->pictures) > 0)
				@foreach($question->pictures as $pic)
					<label for="removeimg{{ $pic->id }}" class="remove-image">
						<input type="checkbox" name="remove[]" value="{{ $pic->id }}" id="removeimg{{ $pic->id }}" />
						<img src="{{ $pic->image_path }}" height="150">
						<i class="fas fa-check"></i>
					</label>
				@endforeach
			@else
				<p>設定中の画像はありません。</p>
			@endif
		</div>
		<input type="hidden" name="id" value="{{ $question->id }}">
		{{ csrf_field() }}
		<input type="submit" class="btn btn-primary" value="更新">
	</form>
</div>
@endsection

@include('layout.footer')