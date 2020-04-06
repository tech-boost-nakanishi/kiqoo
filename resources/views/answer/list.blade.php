@extends('layout.common')
@section('title', '回答一覧 - ' . $appname)

@include('layout.header')
@include('layout.sidebar')

@section('content')
<div class="content">
	<h2 class="content-header">回答一覧</h2>

	@if(session('answeredit'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('answeredit') }}</div>
	@endif

	@if(session('answerdelete'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('answerdelete') }}</div>
	@endif

	@if(session('message'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('message') }}</div>
	@endif

	<table class="table table-striped" style="table-layout: fixed;">
		<thead>
			<th width="25%">投稿日時</th>
			<th width="55%">本文</th>
			<th width="20%">操作</th>
		</thead>
		<tbody>
			@if(count($answers) > 0)
				@foreach($answers as $answer)
					<tr>
						<td>{{ $answer->created_at->format('Y年m月d日 H:i') }}</td>
						<td style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><a href="#">{{ $answer->body }}</a></td>
						<td>
							<a class="btn btn-info" href="{{ route('answer.edit', ['id' => $answer->id]) }}">編集</a>
							<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal{{ $answer->id }}">削除</a>
						</td>
					</tr>

					<div class="modal fade" id="deleteModal{{ $answer->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
				        <div class="modal-dialog">
				            <div class="modal-content">
				                <div class="modal-header">
				                    <h4 class="modal-title" id="myModalLabel">削除確認画面</h4>
				                </div>
				                <div class="modal-body">
				                    <label>本当に削除しますか？</label>
				                </div>
				                <div class="modal-footer">
				                    <a type="button" class="btn btn-default" data-dismiss="modal">閉じる</a>
				                    <a type="button" class="btn btn-danger" href="{{ action('AnswerController@delete', ['id' => $answer->id]) }}">削除</a>
				                </div>
				            </div>
				        </div>
				    </div>
				@endforeach
			@else
				<span>
					回答がありません。
				</span>
			@endif
		</tbody>
	</table>

	<div class="d-flex justify-content-center">
    	{{ $answers->links() }}
	</div>
</div>
@endsection

@include('layout.footer')