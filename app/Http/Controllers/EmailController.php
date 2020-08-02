<?php

namespace App\Http\Controllers;

use App\Services\EmailSender;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * @var EmailSender
     */
    private $emailSender;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmailSender $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    public function sendCode(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $email = $request->get('email');

        $this->emailSender->send($email);
    }
}
