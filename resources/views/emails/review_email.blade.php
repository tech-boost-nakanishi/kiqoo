<!DOCTYPE html>
<html>
    <body>
        <p>
            {{ $name }}さん、いつもご利用いただき誠にありがとうございます。
            <br>
            <br>
            先日ご質問いただいた
            <br>
            「<a href="{{ action('QuestionController@show', ['id' => $question_id]) }}">{{ $question_title }}</a>」に
            <br>
            回答が投稿されました。
            <br>
            是非回答をご覧いただき評価の方していただければ幸いです。
        </p>
        <br>
        <p style="margin: 0;">回答評価ページ</p>
        <p style="margin: 0;"><a href="{{ action('ReviewController@add', ['id' => $answer_id]) }}">{{ action('ReviewController@add', ['id' => $answer_id]) }}</a></p>
        <br>
        何卒、よろしくお願い申し上げます。
        <br>
        <br>
        <p><a href="{{ url('/') }}">{{ $appname }}</a></p>
    </body>
</html>