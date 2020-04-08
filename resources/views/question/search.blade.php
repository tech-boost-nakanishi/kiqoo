@extends('layout.common')
@section('title', '「'.$keyword.'」の検索結果 - ' . $appname)

@include('layout.header')
@include('layout.sidebar')

@section('content')
<div class="content">
	@if(!empty($keyword))
		<h2 style="text-align: center; margin-top: 10px; margin-bottom: 20px; font-size: 26px;">「{{ $keyword }}」の検索結果</h2>

		<p style="margin: 0; text-align: right; font-weight: bold; font-size: 16px;">全{{ count($questions) }}件中 {{ $from }}件〜{{ $to }}件を表示</p>
		<hr style="margin-top: 0;">

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
		    	{{ $pagination->appends(request()->input())->links() }}
			</div>
		@else
			<p style="text-align: center; font-weight: bold; font-size: 18px;">一致する質問はありません。</p>
		@endif
	@else
		<h2 style="text-align: center; margin-top: 10px;">
			キーワードが入力されていません。
		</h2>
	@endif
</div>
@endsection

@include('layout.footer')