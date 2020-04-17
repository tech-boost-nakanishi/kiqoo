@extends('layout.common')
@section('title', '質問一覧 - ' . $appname)

@include('layout.header')
@include('layout.sidebar')

@section('content')
<div class="content col-md-8 col-xs-12">
	<h2 class="content-header">質問一覧</h2>

	@if(session('questionedit'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('questionedit') }}</div>
	@endif

	@if(session('questiondelete'))
		<div class="alert alert-success" role="alert" style="width: 100%;">{{ session('questiondelete') }}</div>
	@endif

	@auth
		@if(Auth::user()->id != $user->id)
			<p class="profile-image" style="float: left; width: 40px; height: 40px; background-image: url('{{ $user->image_path }}');"></p>
			<p style="float: left; margin-top: 5px; margin-left: 5px; font-size: 20px; font-weight: bold;">{{ $user->name }}さん</p>
			<p style="float: right; font-size: 18px; margin: 0; padding-top: 20px;"><a href="{{ action('AnswerController@list', ['id' => $user->id]) }}">回答一覧を見る</a></p>
			<div style="clear: both;"></div>
		@endif
	@endauth
	@guest
		<p class="profile-image" style="float: left; width: 40px; height: 40px; background-image: url('{{ $user->image_path }}');"></p>
		<p style="float: left; margin-top: 5px; margin-left: 5px; font-size: 20px; font-weight: bold;">{{ $user->name }}さん</p>
		<p style="float: right; font-size: 18px; margin: 0; padding-top: 20px;"><a href="{{ action('AnswerController@list', ['id' => $user->id]) }}">回答一覧を見る</a></p>
		<div style="clear: both;"></div>
	@endguest

	<table class="table table-striped" style="table-layout: fixed;">
		<thead>
			@auth
				@if(Auth::user()->id == $user->id)
					<th width="25%">投稿日時</th>
					<th width="55%">タイトル</th>
					<th width="20%">操作</th>
				@else
					<th width="30%">投稿日時</th>
					<th width="70%">タイトル</th>
				@endif
			@endauth
			@guest
				<th width="30%">投稿日時</th>
				<th width="70%">タイトル</th>
			@endguest
				
		</thead>
		<tbody>
			@if(count($questions) > 0)
				@foreach($questions as $question)
					<tr>
						<td>{{ $question->created_at->format('Y年m月d日 H:i') }}</td>
						<td style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><a href="{{ action('QuestionController@show', ['id' => $question->id]) }}">{{ $question->title }}</a></td>
						@auth
							@if(Auth::user()->id == $user->id)
								<td>
									<a class="btn btn-info" href="{{ route('question.edit', ['id' => $question->id]) }}">編集</a>
									<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal{{ $question->id }}">削除</a>
								</td>
							@endif
						@endauth
					</tr>

					@auth
						@if(Auth::user()->id == $user->id)
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
						@endif
					@endauth
				@endforeach
			@else
				<span>
					質問がありません。
				</span>
			@endif
		</tbody>
	</table>

	<div class="d-flex justify-content-center">
    	{{ $questions->appends(request()->input())->links() }}
	</div>
</div>
@endsection

@include('layout.footer')