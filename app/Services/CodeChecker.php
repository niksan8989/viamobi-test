<?php

namespace App\Services;

use App\Repositories\Token;
use Webmozart\Assert\Assert;

class CodeChecker
{
    private Token $tokenRepository;

    public function __construct(Token $repository)
    {
        $this->tokenRepository = $repository;
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

        // Todo::удалить токен и сбросить все счетчики
        $this->tokenRepository->delete($token->id);
    }
}
