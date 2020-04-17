@extends('layout.common')
@section('title', $appname . 'について')

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content col-md-8 col-xs-12">
    <h2 class="content-header">{{ $appname }}について</h2>

    <p style="font-weight: bold; font-size: 18px;">
        本サイトは日頃の悩みや疑問を気軽に質問できるサイトです。<br>
        また他のユーザーの質問に回答することもできます。
        <br>
        @guest
            本サイトを利用するにはまず<a href="{{ url('register') }}">新規会員登録</a>してください。<br>
            すでに登録済の方は<a href="{{ url('login') }}">ログイン</a>してください。
        @endguest
    </p>
</div>
@endsection

@include('layout.footer')