@extends('layout.common')
@section('title', $appname)

@include('layout.header')
           
@include('layout.sidebar')

@section('content')
<div class="content">
    @if(session('logout'))
        <div class="alert alert-info" role="alert" style="width: 100%;">{{ session('logout') }}</div>
    @endif

    <h2 class="content-header">新着一覧</h2>

    @if(count($questions) == 0)
        <p style="text-align: center; font-size: 18px; font-weight: bold;">投稿がありません。</p>
    @endif

    @foreach($questions as $question)
        <div class="search-question-frame">
            <h3 class="search-question-frame-title">{{ $question->title }}</h3>
            <p class="search-question-frame-body">{{ \Str::limit($question->body, 250) }}</p>
            <p class="search-question-frame-date">{{ $question->created_at->format('Y年m月d日 H:i') }}</p>
            <p class="search-question-frame-view">閲覧数：{{ $question->view->view }}</p>
            <div style="clear: both;"></div>
            <a href="{{ action('QuestionController@show', ['id' => $question->id]) }}"></a>
        </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $questions->appends(request()->input())->links() }}
    </div>
</div>
@endsection
@include('layout.footer')