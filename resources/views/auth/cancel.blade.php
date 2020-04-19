@extends('layout.common')
@section('title', '退会申請画面 - ' . $appname)

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content col-md-8 col-xs-12">
    <h2 class="content-header">退会申請画面</h2>

    <p style="display: flex; justify-content: center;"><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal">退会する</a></p>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">退会確認画面</h4>
                </div>
                <div class="modal-body">
                    <label>本当に退会されますか？</label>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-default" data-dismiss="modal">閉じる</a>
                    <a type="button" class="btn btn-danger" href="{{ action('HomeController@delete', ['id' => Auth::user()->id]) }}">削除</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layout.footer')