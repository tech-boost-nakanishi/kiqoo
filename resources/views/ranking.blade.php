@extends('layout.common')
@section('title', 'ランキング - ' . $appname)

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content col-md-8 col-xs-12">
    <h2 class="content-header" style="margin-bottom: -20px;">ランキング</h2>

    <form action="{{ action('RankController@index') }}" method="get" enctype="multipart/form-data" style="margin-bottom: 10px;">
        <div style="border: 1px solid #dcdcdc; padding: 10px; margin: 0 auto;">
            <div class="form-group selectrank">
                <select name="sortby" required>
                    <option value="">選択してください</option>
                    <option value="manyquestions" @if(request()->input('sortby') == 'manyquestions') selected  @endif>質問が多いユーザー順</option>
                    <option value="manyanswers" @if(request()->input('sortby') == 'manyanswers') selected  @endif>回答が多いユーザー順</option>
                    <option value="highreviews" @if(request()->input('sortby') == 'highreviews') selected  @endif>評価が高いユーザー順</option>
                    <option value="manyviewsquestion" @if(request()->input('sortby') == 'manyviewsquestion') selected  @endif>閲覧数が多い質問順</option>
                </select>
            </div>
            {{ csrf_field() }}
            <input type="submit" class="btn btn-primary" value="表示">
        </div>
    </form>

    <div style="clear: both;"></div>

    @if(request()->input('sortby') == "manyquestions" || request()->input('sortby') == "manyanswers" || request()->input('sortby') == "highreviews")
        @if(!empty($pagination))
            @foreach($pagination as $result)
                <div class="user-ranking-frame">
                    <div class="user-ranking-frame-rank">{{ $result->rank }}</div>
                    <p class="profile-image" style="width: 50px; height: 50px; background-image: url('{{ $result->image_path }}'); float: left;"></p>
                    <div class="user-ranking-frame-right">
                        <p><a href="{{ action('ProfileController@show', ['id' => $result->id]) }}">{{ $result->name }}</a>さん</p>
                        <div style="clear: both;"></div>
                        <p><a href="{{ action('QuestionController@list', ['id' => $result->id]) }}">質問：{{ $result->questions }}件</a></p>
                        <p><a href="{{ action('AnswerController@list', ['id' => $result->id]) }}">回答：{{ $result->answers }}件</a></p>
                        <br>
                        <p style="float: left;">平均評価：</p>
                        <div class="review-frame">
                            <div class="review-frame-front" style="width: {{ $result->review_percent }}%;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="review-frame-back">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p style="float: left; font-weight: bold; margin-left: 10px;">{{ round($result->review_avg, 1) }}</p>
                    </div>
                     <div style="clear: both;"></div>
                </div>
                <div style="clear: both;"></div>
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $pagination->appends(request()->input())->links() }}
            </div>
        @endif
    @elseif(request()->input('sortby') == "manyviewsquestion")
        @if(!empty($pagination))
            @foreach($pagination as $question)
                <p style="font-size: 30px; float: left; margin-right: 10px;">{{ $question->rank }}</p>
                <div class="search-question-frame" style="float: left; width: 92%;">
                    <h3 class="search-question-frame-title">{{ $question->title }}</h3>
                    <p class="search-question-frame-body">{{ \Str::limit($question->body, 250) }}</p>
                    <p class="search-question-frame-date">{{ $question->created_at->format('Y年m月d日 H:i') }}</p>
                    <p class="search-question-frame-view">閲覧数：{{ $question->view }}</p>
                    <div style="clear: both;"></div>
                    <a href="{{ action('QuestionController@show', ['id' => $question->id]) }}"></a>
                </div>
                <div style="clear: both;"></div>
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $pagination->appends(request()->input())->links() }}
            </div>
        @endif
    @endif
</div>
@endsection

@include('layout.footer')