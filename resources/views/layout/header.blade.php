@section('header')
<div class="header-bar">
    
    <div class="container">
        <div class="row">
            <header class="col-md-10 col-xs-12">
                <nav class="navbar navbar-expand-md navbar-light" style="background-color: #fff;">
                    <div class="navbar-header">
                        <h1><a href="{{ url('/') }}">{{ $appname }}</a></h1>
                    </div>
                    <div id="searchBox" class="d-none d-sm-block">
                        <form action="{{ action('QuestionController@search') }}" method="get" enctype="multipart/form-data">
                            @if(strpos(url()->current(), '/question/search') != false)
                                <input type="text" class="form-control" name="keyword" value="{{ $keyword }}" placeholder="キーワードで検索">
                            @else
                                <input type="text" class="form-control" name="keyword" value="" placeholder="キーワードで検索">
                            @endif
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </form>
                    </div>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto" style="font-size: 18px;">
                            @guest
                                <li><a class="nav-link" href="{{ url('login') }}">ログイン</a></li>
                                <li><a class="nav-link" href="{{ url('register') }}">新規登録</a></li>
                            @else
                                <li class="dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative; padding-left: 60px;">
                                        <p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ Auth::user()->image_path }}'); position: absolute; left: 10px; top: 0px;"></p>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="margin-top: 10px; font-size: 18px;">
                                        <a class="dropdown-item" href="{{ action('ProfileController@show', ['id' => Auth::user()->id]) }}">
                                            マイページ
                                        </a>
                                        <a class="dropdown-item" href="{{ action('ProfileController@edit') }}">
                                            プロフィール編集
                                        </a>
                                        <a class="dropdown-item" href="{{ action('QuestionController@add') }}">
                                            質問する
                                        </a>
                                        <a class="dropdown-item" href="{{ action('QuestionController@list', ['id' => Auth::user()->id]) }}">
                                            質問一覧
                                        </a>
                                        <a class="dropdown-item" href="{{ action('AnswerController@list', ['id' => Auth::user()->id]) }}">
                                            回答一覧
                                        </a>
                                        <a class="dropdown-item" href="{{ action('ReviewController@list') }}">
                                            未評価回答一覧
                                        </a>
                                        <a class="dropdown-item" href="{{ action('HomeController@cancel') }}">
                                            退会する
                                        </a>
                                        <a class="dropdown-item" href="{{ url('logout') }}">
                                            ログアウト
                                        </a>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                    <div class="collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav d-block d-sm-none" style="font-size: 20px; padding-top: 10px;">
                            <li style="padding: 5px;">
                                <a href="/">Home</a>
                            </li>
                            <li style="padding: 5px;">
                                <a href="{{ url('ranking') }}">Ranking</a>
                            </li>
                            <li style="padding: 5px;">
                                <a href="{{ url('about') }}">About</a>
                            </li>
                        </ul>
                        <div id="searchBox" class="d-block d-sm-none">
                            <form action="{{ action('QuestionController@search') }}" method="get" enctype="multipart/form-data">
                                @if(strpos(url()->current(), '/question/search') != false)
                                    <input type="text" class="form-control" name="keyword" value="{{ $keyword }}" placeholder="キーワードで検索">
                                @else
                                    <input type="text" class="form-control" name="keyword" value="" placeholder="キーワードで検索">
                                @endif
                                {{ csrf_field() }}
                                <input type="submit" class="btn btn-primary" value="検索">
                            </form>
                        </div>
                    </div>
                </nav>
            </header>
        </div>
    </div>
</div>
@endsection