<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $question_id, $question_title, $answer_id)
    {
        $this->name = $name;
        $this->title = sprintf('%sさんの質問に回答がありました。', $name);
        $this->question_id = $question_id;
        $this->question_title = $question_title;
        $this->answer_id = $answer_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.review_email')
                    ->text('emails.review_email_plain')
                    ->subject($this->title)
                    ->with([
                        'name' => $this->name,
                        'question_id' => $this->question_id,
                        'question_title' => $this->question_title,
                        'answer_id' => $this->answer_id,
                      ]);
    }
}
