@extends('layout.common')
@section('title', $user->name . 'さんのプロフィール - ' . $appname)

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content col-md-8 col-xs-12">
    @if(session('login'))
        <div class="alert alert-info" role="alert" style="width: 100%;">{{ session('login') }}</div>
    @endif

    @if(session('register'))
        <div class="alert alert-info" role="alert" style="width: 100%;">{{ session('register') }}</div>
    @endif
    
    <h2 class="content-header">プロフィール画面</h2>

    <div class="profile-area">
        <div class="container">
            <div class="row">
                <div class="profile-area-top" style="margin: 20px auto; text-align: center;">
                    <div class="profile-area-top-left col-md-12 col-xs-12">
                        <p class="profile-image" style="width: 150px; height: 150px; background-image: url('{{ $user->image_path }}');"></p>
                    </div>
                    
                    <div class="profile-area-top-right col-md-12 col-xs-12">
                        <p style="font-size: 24px; font-weight: bold;">{{ $user->name }} さん</p>
                        <p style="font-size: 22px; font-weight: bold; float: left;">平均評価：</p>
                        <div class="review-frame" style="float: left; margin-top: 5px;">
                            <div class="review-frame-front" style="width: {{ $review_percent }}%;">
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
                        <p style="float: left; font-size: 24px; font-weight: bold; margin-left: 10px;">{{ $review_avg }}</p>
                        <div style="clear: both;"></div>
                        <p style="font-weight: bold; font-size: 17px;">(評価件数：{{ $count }}件)</p>
                        <a href="{{ action('QuestionController@list', ['id' => $user->id]) }}" style="font-weight: bold; font-size: 20px;"><p>質問一覧({{ count($user->questions) }}件)</p></a>
                        <a href="{{ action('AnswerController@list', ['id' => $user->id]) }}" style="font-weight: bold; font-size: 20px;"><p>回答一覧({{ count($user->answers) }}件)</p></a>
                    </div>
                </div>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="profile-area-bottom">
            <div style="width: 100%; background-color: #dcdcdc; font-size: 20px; padding: 5px; border-radius: 5px;">
                資格
            </div>
            @if(!is_null($user->qualification))
                <p>{{ $user->qualification }}</p>
            @else
                <p>未設定です。</p>
            @endif

            <div style="width: 100%; background-color: #dcdcdc; font-size: 20px; padding: 5px; border-radius: 5px;">
                趣味
            </div>
            @if(!is_null($user->hobby))
                <p>{{ $user->hobby }}</p>
            @else
                <p>未設定です。</p>
            @endif

            <div style="width: 100%; background-color: #dcdcdc; font-size: 20px; padding: 5px; border-radius: 5px;">
                自己紹介
            </div>
            @if(!is_null($user->introduction))
                <p>{{ $user->introduction }}</p>
            @else
                <p>未設定です。</p>
            @endif
        </div>
    </div>
</div>
@endsection

@include('layout.footer')