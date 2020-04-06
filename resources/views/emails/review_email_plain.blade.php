{{ $name }}さん、いつもご利用いただき誠にありがとうございます。

先日ご質問いただいた
「{{ $question_title }}」に
回答が投稿されました。
是非回答をご覧いただき評価の方していただければ幸いです。

回答評価ページ
{{ action('ReviewController@add', ['id' => $answer_id]) }}

何卒、よろしくお願い申し上げます。

{{ $appname }}