@extends('layout.common')
@section('title', '回答投稿画面 - kiqoo')

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content">
	<h2 class="content-header">回答投稿画面</h2>

	@if(session('message'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('message') }}</div>
	@endif

	<a href="#" class="btn btn-primary question-btn" data-toggle="modal" data-target="#questionModal">質問を見る</a>

	<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 760px; height: 500px; margin-left: -130px;">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ \Str::limit($question->title, 10) }}</h4>
                </div>
                <div class="modal-body" style="overflow: scroll;">
                    <div class="question-display-frame">
						<div class="question-display-frame-left">
							<p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ $user->image_path }}');"></p>
							<p><a href="#">{{ $user->name }}</a></p>
							<div class="question-display-frame-date">
								<p>投稿:{{ $question->created_at->format('Y年m月d日 H:i') }}</p>
								@if($question->created_at != $question->updated_at)
									<p>更新:{{ $question->updated_at->format('Y年m月d日 H:i') }}</p>
								@endif
							</div>
						</div>
						<h2 class="question-display-frame-title">{{ $question->title }}</h2>
						<hr style="clear: both;">
						<p class="question-display-frame-body">{{ $question->body }}</p>
						@if(!is_null($question->image_path))
							<img src="{{ $question->image_path }}" alt="{{ $question->title }}" width="300">
						@endif
					</div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-default" data-dismiss="modal">閉じる</a>
                </div>
            </div>
        </div>
    </div>

	<form action="{{ action('AnswerController@create') }}" method="post" enctype="multipart/form-data">
		<div class="form-group row">
			@if($errors->has('body'))
			　　<div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errors->first('body') }}</div>
			@endif
			<label>本文</label>
			<textarea class="form-control" name="body" rows="15" placeholder="回答文を入力してください">{{ old('body') }}</textarea>
		</div>
		<div class="form-group row">
			<label>画像:</label>
			<input type="file" class="form-control-file" name="image_path">
		</div>
		<input type="hidden" name="question_id" value="{{ $question->id }}">
		{{ csrf_field() }}
		<input type="submit" class="btn btn-primary" value="投稿">
	</form>
</div>
@endsection

@include('layout.footer')