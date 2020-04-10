@extends('layout.common')
@section('title', '未評価回答一覧 - ' . $appname)

@include('layout.header')
@include('layout.sidebar')

@section('content')
<div class="content">
	<h2 class="content-header">未評価回答一覧</h2>

	@if(session('questionedit'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('questionedit') }}</div>
	@endif

	<table class="table table-striped" style="table-layout: fixed;">
		<thead>
			<th width="25%">回答投稿日時</th>
			<th width="55%">回答本文</th>
			<th width="20%">操作</th>
		</thead>
		<tbody>
			@if(count($answers) > 0)
				@foreach($answers as $answer)
					@if(!is_null($answer))
					<tr>
						<td>{{ $answer->created_at->format('Y年m月d日 H:i') }}</td>
						<td><a href="{{ action('ReviewController@add', ['id' => $answer->id]) }}">{{ \Str::limit($answer->body, 10) }}</a></td>
						<td><a class="btn btn-info" href="{{ action('ReviewController@add', ['id' => $answer->id]) }}">評価する</a></td>
					</tr>
					@endif
				@endforeach
			@else
				<span>
					未評価の回答はありません。
				</span>
			@endif
		</tbody>
	</table>
</div>
@endsection

@include('layout.footer')