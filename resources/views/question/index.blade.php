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
		<p class="question-display-frame-title">{{ $question->title }}</p>
		<hr style="clear: both;">
		<p class="question-display-frame-body">{{ $question->body }}</p>
		@if(!is_null($question->image_path))
			<img src="{{ $question->image_path }}" alt="{{ $question->title }}" width="300">
		@endif
	</div>

@auth
<a href="#" class="btn btn-primary answer-btn">回答する</a>
@endauth
</div>
@endsection

@include('layout.footer')