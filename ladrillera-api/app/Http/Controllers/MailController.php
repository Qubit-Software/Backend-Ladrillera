<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AccountEmail;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function sendConfirmEmail($userName, $email, $password)
    {
        $msg = new \stdClass();
        $msg->userName = $userName;
        $msg->email = $email;
        $msg->sender = 'Ladrillera 21';
        $msg->receiver = $email;
        $msg->password = $password;

        // First get a pending email and then send
        Mail::to($msg->receiver)->send(new AccountEmail($msg));
    }
}
