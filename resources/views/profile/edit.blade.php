@extends('layout.common')
@section('title', 'プロフィール編集画面 - ' . $appname)

@include('layout.header')

@include('layout.sidebar')

@section('content')
<div class="content">
	<h2 class="content-header">プロフィール編集画面</h2>

	@if(session('profileedit'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('profileedit') }}</div>
	@endif

	<form action="{{ action('ProfileController@update') }}" method="post" enctype="multipart/form-data">
		<div class="form-group row" style="position: relative;">
			<p class="profile-image" style="width: 150px; height: 150px; background-image: url('{{ Auth::user()->image_path }}');"></p>
			<input type="file" class="form-control-file" name="image_path" style="width: 500px; position: absolute; top: 120px; left: 150px;">
		</div>
		<div class="form-group row">
			<label>資格</label><p style="font-weight: bold; font-size: 18px; margin: 0;">（複数ある場合は/で区切ってください。）</p>
			<input type="text" class="form-control" name="qualification" value="{{ Auth::user()->qualification }}">
		</div>
		<div class="form-group row">
			<label>趣味</label><p style="font-weight: bold; font-size: 18px; margin: 0;">（複数ある場合は/で区切ってください。）</p>
			<input type="text" class="form-control" name="hobby" value="{{ Auth::user()->hobby }}">
		</div>
		<div class="form-group row">
			<label>自己紹介</label>
			<textarea class="form-control" name="introduction" rows="15">{{ Auth::user()->introduction }}</textarea>
		</div>
		{{ csrf_field() }}
		<input type="submit" class="btn btn-primary" value="投稿">
	</form>
</div>
@endsection

@include('layout.footer')