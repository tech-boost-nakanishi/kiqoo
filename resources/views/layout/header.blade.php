@section('header')
<div class="header-bar">
    <div class="row">
        <header class="col-md-6 col-sm-12">
           <h1><a href=" {{ url('/') }}">{{ $appname }}</a></h1>
            <form action="{{ action('QuestionController@search') }}" method="get" enctype="multipart/form-data">
                @if(strpos(url()->current(), '/question/search') != false)
                    <input type="text" class="form-control" name="keyword" value="{{ $keyword }}" placeholder="キーワードで検索">
                @else
                    <input type="text" class="form-control" name="keyword" value="" placeholder="キーワードで検索">
                @endif
                {{ csrf_field() }}
                <input type="submit" class="btn btn-primary" value="検索">
            </form>
            <ul class="right-nav">
                @guest
                    <li><a class="nav-link" href="{{ url('login') }}">ログイン</a></li>
                    <li><a class="nav-link" href="{{ url('register/emailcheck') }}">新規登録</a></li>
                @else
                    <li class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative; padding-left: 60px;">
                            <p class="profile-image" style="width: 45px; height: 45px; background-image: url('{{ Auth::user()->image_path }}'); position: absolute; left: 10px;"></p>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ action('QuestionController@add') }}">
                                質問する
                            </a>
                            <a class="dropdown-item" href="{{ action('ProfileController@edit') }}" style="font-size: 15px;">
                                プロフィール編集
                            </a>
                            <a class="dropdown-item" href="{{ action('QuestionController@list', ['id' => Auth::user()->id]) }}">
                                質問一覧
                            </a>
                            <a class="dropdown-item" href="{{ action('AnswerController@list', ['id' => Auth::user()->id]) }}">
                                回答一覧
                            </a>
                            <a class="dropdown-item" href="{{ action('ReviewController@list') }}" style="font-size: 16px;">
                                未評価回答一覧
                            </a>
                            <a class="dropdown-item" href="{{ url('logout') }}">
                                ログアウト
                            </a>
                        </div>
                    </li>
                @endguest
            </ul>
        </header>
    </div>
</div>
@endsection