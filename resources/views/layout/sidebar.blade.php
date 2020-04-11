@section('sidebar')

<div class="sidebar">
    <ul class="side-menu">
        <li>
            <a href="/">Home</a>
        </li>
        <li>
            <a href="{{ url('ranking') }}">Ranking</a>
        </li>
        <li>
            <a href="{{ url('about') }}">About</a>
        </li>
    </ul>
</div>

@endsection