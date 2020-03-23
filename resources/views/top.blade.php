@extends('layout.common')
@section('title', 'kiqoo')

@include('layout.header')
           
@include('layout.sidebar')

@section('content')
<div class="content">
    @if(session('login'))
        <div class="alert alert-info" role="alert" style="width: 100%;">{{ session('login') }}</div>
    @endif
    @if(session('logout'))
        <div class="alert alert-info" role="alert" style="width: 100%;">{{ session('logout') }}</div>
    @endif

    <h2 class="content-header">新着一覧</h2>

    @foreach($questions as $question)
        <div class="search-question-frame">
            <h3 class="search-question-frame-title">{{ $question->title }}</h3>
            <p class="search-question-frame-body">{{ \Str::limit($question->body, 250) }}</p>
            <p class="search-question-frame-date">{{ $question->created_at->format('Y年m月d日 H:i') }}</p>
            <a href="{{ action('QuestionController@show', ['id' => $question->id]) }}"></a>
        </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $questions->links() }}
    </div>
</div>
@endsection
        @include('layout.footer')