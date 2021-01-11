<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Http\Schemas\Mail\AccountEmail;

class EmailService
{
    public function sendConfirmationEmail($user_name, $email, $password)
    {
        $msg = new \stdClass();
        $msg->user_name = $user_name;
        $msg->email = $email;
        $msg->sender = 'Ladrillera 21';
        $msg->receiver = $email;
        $msg->password = $password;

        // First get a pending email and then send
        Mail::to($msg->receiver)->send(new AccountEmail($msg));
    }
}
