<?php

namespace App\Http\Schemas\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class AccountEmail extends Mailable
{
    static $accounts_counter = 0;
    use Queueable, SerializesModels;

    private $from_email;
    /**
     * The message object instance that contains the info to extract in the template.
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
        $this->from_email = env('MAIL_FROM_ADDRESS', Config::get('constants.from_email'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this::$accounts_counter = $this::$accounts_counter  + 1;
        return $this->from($this->from_email)
            ->view('mails.ConfirmMsg')
            ->text('mails.ConfirmMsgPlain')
            ->with(
                [
                    'accounts_counter' => $this::$accounts_counter,
                ]
            );
    }
}
