@section('sidebar')
<!-- <div class="col-md-1"></div> -->
<div class="sidebar col-md-3 col-xs-12" style="display: flex; justify-content: center;">
    <div class="row">
        <ul class="side-menu col-md-12">
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
</div>

@endsection