<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountEmail extends Mailable
{
    static $accountsCounter = 0;
    use Queueable, SerializesModels;
    /**
     * The message object instance.
     *
     * @var msg
     */
    public $msg;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this::$accountsCounter = $this::$accountsCounter  + 1;
        return $this->from('sender@example.com')
            ->view('mails.ConfirmMsg')
            ->text('mails.ConfirmMsgPlain')
            ->with(
                [
                    'accountsCounter' => $this::$accountsCounter,
                ]
            );
    }
}
