<?php

namespace App\Http\Controllers;

use App\Services\CodeChecker;
use App\Services\EmailSender;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    private EmailSender $emailSender;
    private CodeChecker $codeChecker;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmailSender $emailSender, CodeChecker $codeChecker)
    {
        $this->emailSender = $emailSender;
        $this->codeChecker = $codeChecker;
    }

    public function sendCode(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $email = $request->get('email');

        try {
            $this->emailSender->send($email);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json([
                'status'   => 'error',
                'message'  => $e->getMessage(),
            ], 400);
        }
    }

    public function checkCode(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'code' => 'required|size:4'
        ]);

        $email = $request->get('email');
        $code = $request->get('code');

        try {
            $this->codeChecker->check($email, $code);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json([
                'status'   => 'error',
                'message'  => $e->getMessage(),
            ], 400);
        }
    }
}
