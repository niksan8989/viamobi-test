<?php

namespace App\Services;

use App\Models\Email;
use App\Repositories\EmailRepository;
use App\Repositories\TokenRepository;
use Webmozart\Assert\Assert;

class CodeChecker
{
    private TokenRepository $tokenRepository;
    /**
     * @var EmailRepository
     */
    private EmailRepository $emailRepository;

    public function __construct(TokenRepository $tokenRepository, EmailRepository $emailRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->emailRepository = $emailRepository;
    }

    public function check($email, $code): void
    {
        Assert::email($email, "Необходимо предоставить корректный email");
        Assert::length($code, 4);

        if (!$token = $this->tokenRepository->findByEmail($email)) {
            throw new \DomainException("Для данного email не был сгенирирован код. Воспользуйтесь методом sendCode");
        }

        $token->attempt();
        $token->validate($code, new \DateTimeImmutable());
        $token->delete();

        Email::create(['email' => $email]);
    }
}
