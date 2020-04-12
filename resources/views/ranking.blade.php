@extends('layout.common')
@section('title', 'ランキング - ' . $appname)

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content">
    <h2 class="content-header" style="margin-bottom: -20px;">ランキング</h2>

    <form action="{{ action('RankController@index') }}" method="get" enctype="multipart/form-data">
        <div style="border: 1px solid #dcdcdc; padding: 10px; width: 500px; margin: 0 auto;">
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

    @if(request()->input('sortby') == "manyquestions")
        <p>質問が多いユーザー順</p>
    @elseif(request()->input('sortby') == "manyanswers")
        <p>回答が多いユーザー順</p>
    @elseif(request()->input('sortby') == "highreviews")
        <p>評価が高いユーザー順</p>
    @elseif(request()->input('sortby') == "manyviewsquestion")
        <p>閲覧数が多い質問順</p>
    @endif
</div>
@endsection

@include('layout.footer')