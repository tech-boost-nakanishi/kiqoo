@extends('layout.common')
@section('title', '回答投稿画面 - ' . $appname)

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content col-md-8 col-xs-12">
	@if(session('login'))
        <div class="alert alert-info" role="alert" style="width: 100%;">{{ session('login') }}</div>
    @endif

    @if(session('register'))
        <div class="alert alert-info" role="alert" style="width: 100%;">{{ session('register') }}</div>
    @endif

	<h2 class="content-header">回答投稿画面</h2>

	<a href="#" class="btn btn-primary question-btn" data-toggle="modal" data-target="#questionModal">質問を見る</a>

	<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="height: 500px;">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ \Str::limit($question->title, 10) }}</h4>
                </div>
                <div class="modal-body" style="overflow: scroll;">
                    <div class="question-display-frame">
						<div class="question-display-frame-left">
							<p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ $question->user->image_path }}');"></p>
							<p><a href="{{ action('ProfileController@show', ['id' => $question->user->id]) }}">{{ $question->user->name }}</a>さん</p>
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
						@foreach($question->pictures as $picture)
							<img src="{{ $picture->image_path }}" alt="" width="300">
						@endforeach
					</div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-default" data-dismiss="modal">閉じる</a>
                </div>
            </div>
        </div>
    </div>
	<div class="container">
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
				<input type="file" class="form-control-file" name="image_paths[]" multiple>
			</div>
			<input type="hidden" name="question_id" value="{{ $question->id }}">
			@if(!empty($question))
				<input type="hidden" name="question_user_id" value="{{ $question->user_id }}">
			@endif
			{{ csrf_field() }}
			<input type="submit" class="btn btn-primary" value="投稿">
		</form>
	</div>
</div>
@endsection

@include('layout.footer')