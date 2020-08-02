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

    /**
     * @api {get} /sendCode Генерация и отправка секретного кода на указанный email
     * @apiName SendCode
     * @apiVersion 0.1.0
     * @apiGroup Email
     *
     * @apiParam {String} email Email для отпрвки сгенерированного кода.
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost:8080/sendCode?email=test@example.com
     *
     * @apiSuccess {String} status Полученный статус.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": "success"
     *     }
     *
     * @apiError BadRequest Error message.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "email": "error",
     *       "message": "Error message"
     *     }
     */
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

    /**
     * @api {get} /checkCode Сверка указанного кода с тем, что был ранее отправлен на указанный email.
     * @apiName CheckCode
     * @apiVersion 0.1.0
     * @apiGroup Email
     *
     * @apiParam {String} email Email, который необходимо провалидировать.
     * @apiParam {String} code Код для проверки.
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost:8080/checkCode?email=test@example.com&code=1793
     *
     * @apiSuccess {String} status Полученный статус.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": "success"
     *     }
     *
     * @apiError BadRequest Error message.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "email": "error",
     *       "message": "Error message"
     *     }
     */
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
