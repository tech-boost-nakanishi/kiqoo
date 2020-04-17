@extends('layout.common')
@section('title', \Str::limit($question->title, 20) . ' - ' . $appname)

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content col-md-8 col-xs-12">
	<div class="question-display-frame">
		<div class="question-display-frame-left">
			<p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ $question->user->image_path }}');"></p>
			<p><a href="{{ action('ProfileController@show', ['id' => $question->user->id]) }}">{{ $question->user->name }}</a></p>
			<div class="question-display-frame-date">
				<p>投稿:{{ $question->created_at->format('Y年m月d日 H:i') }}</p>
				@if($question->created_at != $question->updated_at)
					<p>更新:{{ $question->updated_at->format('Y年m月d日 H:i') }}</p>
				@endif
				<p>閲覧数：{{ $question->view->view }}</p>
			</div>
		</div>
		<h2 class="question-display-frame-title">{{ $question->title }}</h2>
		<hr style="clear: both;">
		<p class="question-display-frame-body">{{ $question->body }}</p>
		@foreach($question->pictures as $picture)
			<img src="{{ $picture->image_path }}" alt="" width="300">
			<br>
		@endforeach
	</div>

@auth
<a href="{{ action('AnswerController@add', ['id' => $question->id]) }}" class="btn btn-primary answer-btn">回答する</a>
@endauth

@guest
<form action="{{ route('login') }}" method="get" enctype="multipart/form-data">
	<input type="hidden" name="redirectafterregister" value="{{ $question->id }}">
	{{ csrf_field() }}
	<input type="submit" class="btn btn-primary" value="ログインして回答する" style="font-size: 18px;">
</form>
<!-- <a href="{{ action('AnswerController@add', ['id' => $question->id]) }}" class="btn btn-primary answer-btn" style="width: 220px;">ログインして回答する</a> -->
@endguest

	<div class="answer-count">
		回答({{ count($answers) }}件)
	</div>

	@if(count($answers) > 0)
		@foreach($answers as $answer)
			<div class="answer-display-frame">
				<div class="answer-display-frame-left">
					<p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ $answer->user->image_path }}');"></p>
					<p><a href="{{ action('ProfileController@show', ['id' => $answer->user->id]) }}">{{ $answer->user->name }}</a></p>
					<div class="answer-display-frame-date">
						<p>投稿:{{ $answer->created_at->format('Y年m月d日 H:i') }}</p>
						@if($answer->created_at != $answer->updated_at)
							<p>更新:{{ $answer->updated_at->format('Y年m月d日 H:i') }}</p>
						@endif
					</div>
				</div>
				<div class="answer-display-frame-right">
					<p class="answer-display-frame-body">{{ $answer->body }}</p>
					@foreach($answer->pictures as $picture)
						<img src="{{ $picture->image_path }}" alt="" width="300">
					@endforeach
				</div>
			</div>
		@endforeach
	@else
		<p>回答はありません。</p>
	@endif

</div>
@endsection

@include('layout.footer')