@extends('layout.common')
@section('title', '「'.$keyword.'」の検索結果 - kiqoo')

@include('layout.header')
@include('layout.sidebar')

@section('content')
<div class="content">
	@if(!empty($keyword))
		<h2 style="text-align: center; margin-top: 10px;">「{{ $keyword }}」の検索結果<br>
		（30件）
		</h2>
	@else
		<h2 style="text-align: center; margin-top: 10px;">
			キーワードが入力されていません。
		</h2>
	@endif
</div>
@endsection

@include('layout.footer')