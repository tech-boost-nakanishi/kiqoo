<!DOCTYPE html>
<html>
<body>
	<p>
		この度は登録ありがとうございます。<br>
		下記の本登録用のリンクをクリックし本登録を完了させてください。
	</p>
	<p>
		<a href="{{ url('register/emailcheck/' . $email . '/' . $token) }}">
			{{ url('register/emailcheck/' . $email . '/' . $token) }}
		</a>
	</p>
	<p><a href="{{ url('/') }}">kiqoo</a></p>
</body>
</html>