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
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="z-index: 999;">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </header>
</div>
@endsection