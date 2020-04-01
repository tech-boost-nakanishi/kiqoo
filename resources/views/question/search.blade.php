@extends('layout.common')
@section('title', '「'.$keyword.'」の検索結果 - kiqoo')

@include('layout.header')
@include('layout.sidebar')

@section('content')
<div class="content">
	@if(!empty($keyword))
		<h2 style="text-align: center; margin-top: 10px; margin-bottom: 20px;">「{{ $keyword }}」の検索結果<br>
		（{{ count($questions) }}件）
		</h2>

		@if(count($questions) > 0)
			@foreach($pagination as $question)
		        <div class="search-question-frame">
		            <h3 class="search-question-frame-title">{!! $question->title !!}</h3>
		            <p class="search-question-frame-body">{!! \Str::limit($question->body, 250) !!}</p>
		            <p class="search-question-frame-date">{{ $question->created_at->format('Y年m月d日 H:i') }}</p>
		            <a href="{{ action('QuestionController@show', ['id' => $question->id]) }}"></a>
		        </div>
		    @endforeach

		    <div class="d-flex justify-content-center">
		    	{{ $pagination->appends([ 'keyword' => $keyword ])->links() }}
			</div>
		@else
			<p style="text-align: center; font-weight: bold; font-size: 18px;">一致するデータがありません。</p>
		@endif
	@else
		<h2 style="text-align: center; margin-top: 10px;">
			キーワードが入力されていません。
		</h2>
	@endif
</div>
@endsection

@include('layout.footer')