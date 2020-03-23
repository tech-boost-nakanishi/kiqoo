@extends('layout.common')
@section('title', '質問一覧 - kiqoo')

@include('layout.header')
@include('layout.sidebar')

@section('content')
<div class="content">
	<h2 class="content-header">質問一覧</h2>

	@if(session('questionedit'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('questionedit') }}</div>
	@endif

	@if(session('questiondelete'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('questiondelete') }}</div>
	@endif

	<table class="table table-striped" style="table-layout: fixed;">
		<thead>
			<th width="25%">投稿日時</th>
			<th width="55%">タイトル</th>
			<th width="20%">操作</th>
		</thead>
		<tbody>
			@foreach($questions as $question)
				<tr>
					<td>{{ $question->created_at->format('Y年m月d日 H:i') }}</td>
					<td style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><a href="{{ action('QuestionController@show', ['id' => $question->id]) }}">{{ $question->title }}</a></td>
					<td>
						<a class="btn btn-info" href="{{ route('question.edit', ['id' => $question->id]) }}">編集</a>
						<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal{{ $question->id }}">削除</a>
					</td>
				</tr>

				<div class="modal fade" id="deleteModal{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
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
			                    <a type="button" class="btn btn-danger" href="{{ action('QuestionController@delete', ['id' => $question->id]) }}">削除</a>
			                </div>
			            </div>
			        </div>
			    </div>
			@endforeach
		</tbody>
	</table>

	<div class="d-flex justify-content-center">
    	{{ $questions->links() }}
	</div>
</div>
@endsection

@include('layout.footer')