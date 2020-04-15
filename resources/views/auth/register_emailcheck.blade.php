@extends('layout.common')
@section('title', '新規仮登録 - ' . $appname)

@include('layout.header')

@section('auth')
<div class="auth-area">
    <div class="row justify-content-center">
        <div class="col-md-8 middle">
            <div class="card">
                <div class="card-header orange auth-header">新規仮登録</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->has('email'))
                        <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errors->first('email') }}</div>
                    @endif

                    <form method="POST" action="{{ action('Auth\RegisterController@emailcheck') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    送信
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layout.footer')
