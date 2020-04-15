<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.register_emailcheck')
                    ->text('emails.register_emailcheck_plain')
                    ->subject('【' . config('app.name') . '】仮登録が完了しました。')
                    ->with([
                        'email' => $this->user->email,
                        'token' => $this->user->email_verify_token,
                      ]);
    }
}
