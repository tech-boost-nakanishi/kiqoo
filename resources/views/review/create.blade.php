@extends('layout.common')
@section('title', '回答評価画面 - kiqoo')

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content">
	<h2 class="content-header">回答評価画面</h2>

	@if(session('message'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('message') }}</div>
	@endif

	@if(!empty($answer->question))
		<a href="#" class="btn btn-primary question-btn" data-toggle="modal" data-target="#questionModal">質問を見る</a>

		<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	        <div class="modal-dialog">
	            <div class="modal-content" style="width: 760px; height: 500px; margin-left: -130px;">
	                <div class="modal-header">
	                    <h4 class="modal-title" id="myModalLabel">{{ \Str::limit($answer->question->title, 10) }}</h4>
	                </div>
	                <div class="modal-body" style="overflow: scroll;">
	                    <div class="question-display-frame">
							<div class="question-display-frame-left">
								<p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ $answer->question->user->image_path }}');"></p>
								<p><a href="#">{{ $answer->question->user->name }}</a></p>
								<div class="question-display-frame-date">
									<p>投稿:{{ $answer->question->created_at->format('Y年m月d日 H:i') }}</p>
									@if($answer->question->created_at != $answer->question->updated_at)
										<p>更新:{{ $answer->question->updated_at->format('Y年m月d日 H:i') }}</p>
									@endif
								</div>
							</div>
							<h2 class="question-display-frame-title">{{ $answer->question->title }}</h2>
							<hr style="clear: both;">
							<p class="question-display-frame-body">{{ $answer->question->body }}</p>
							@foreach($answer->question->pictures as $picture)
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
	@else
		<p style="text-align: center; font-weight: bold; font-size: 20px;">質問は削除済です。</p>
	@endif

	@if(!empty($answer))
		<div class="answer-display-frame">
			<div class="answer-display-frame-left">
				<p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ $answer->user->image_path }}');"></p>
				<p><a href="#">{{ $answer->user->name }}</a></p>
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

		<form action="{{ action('ReviewController@update') }}" method="post" enctype="multipart/form-data">
			<div class="form-group row review-area">
				<input type="radio" name="review" id="review0" value="0">
				<label for="review0">0</label>
				<input type="radio" name="review" id="review1" value="1">
				<label for="review1">1</label>
				<input type="radio" name="review" id="review2" value="2">
				<label for="review2">2</label>
				<input type="radio" name="review" id="review3" value="3">
				<label for="review3">3</label>
				<input type="radio" name="review" id="review4" value="4">
				<label for="review4">4</label>
				<input type="radio" name="review" id="review5" value="5">
				<label for="review5">5</label>
				@if(!empty($answer))
					<input type="hidden" name="answer_id" value="{{ $answer->id }}">
				@endif
			</div>
			{{ csrf_field() }}
			<input type="submit" class="btn btn-primary" value="評価">
		</form>
	@else
		<p style="text-align: center; font-weight: bold; font-size: 20px;">回答は削除されました。</p>
	@endif
</div>
@endsection

@include('layout.footer')