@section('header')
<div class="header-bar">
    <header>
       <h1><a href=" {{ url('/') }}">kiqoo</a></h1>
        <form action="" method="get">
            <input type="text" class="form-control" name="" value="" placeholder="キーワードで検索">
            {{ csrf_field() }}
            <input type="submit" class="btn btn-primary" value="検索">
        </form>
        <ul class="right-nav">
            @guest
                <li><a class="nav-link" href="{{ url('login') }}">ログイン</a></li>
                <li><a class="nav-link" href="{{ url('register') }}">新規登録</a></li>
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
                        <a class="dropdown-item" href="{{ url('list/questions') }}">
                            質問一覧
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
@endsection