@extends('layout.common')
@section('title', '新規仮登録 - ' . $appname)

@include('layout.header')

@section('auth')
<div class="auth-area col-md-12">
    <div class="row justify-content-center">
        <div class="col-md-8 middle">
            <div class="card">
                <div class="card-header orange auth-header">新規仮登録</div>

                <div class="card-body" style="text-align: center;">
                    メールアドレス宛に本登録用のリンクを記載しています。<br>
                    そちらをクリックし本登録を完了させてください。
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layout.footer')
