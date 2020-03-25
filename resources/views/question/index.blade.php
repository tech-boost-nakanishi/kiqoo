@extends('layout.common')
@section('title', \Str::limit($question->title, 20) . ' - kiqoo')

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content">
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

@auth
<a href="{{ action('AnswerController@add', ['id' => $question->id]) }}" class="btn btn-primary answer-btn">回答する</a>
@endauth

	<div class="answer-count">
		回答({{ $answers_count }}件)
	</div>

	@for($i=0; $i<$answers_count; $i++)
		<div class="answer-display-frame">
			<div class="answer-display-frame-left">
				<p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ $answer_user[$i]->image_path }}');"></p>
				<p><a href="#">{{ $answer_user[$i]->name }}</a></p>
				<div class="answer-display-frame-date">
					<p>投稿:{{ $answers[$i]->created_at->format('Y年m月d日 H:i') }}</p>
					@if($answers[$i]->created_at != $answers[$i]->updated_at)
						<p>更新:{{ $answers[$i]->updated_at->format('Y年m月d日 H:i') }}</p>
					@endif
				</div>
			</div>
			<p class="answer-display-frame-body">{{ $answers[$i]->body }}</p>
			@if(!is_null($answers[$i]->image_path))
				<img src="{{ $answers[$i]->image_path }}" alt="{{ \Str::limit($answers[$i]->body, 15) }}" width="300">
			@endif
		</div>
	@endfor

</div>
@endsection

@include('layout.footer')