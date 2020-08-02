<?php

namespace App\Services;

use App\Repositories\TokenRepository;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

class EmailSender
{
    private Tokenizer $tokenizer;
    private TokenRepository $tokenRepository;
    private Sender $sender;

    public function __construct(
        Tokenizer $tokenizer,
        TokenRepository $tokenRepository,
        Sender $sender
    )
    {
        $this->tokenizer = $tokenizer;
        $this->tokenRepository = $tokenRepository;
        $this->sender = $sender;
    }

    public function send($email): void
    {
        Assert::email($email, "Необходимо предоставить корректный email");

        if ($token = $this->tokenRepository->findByEmail($email)) {
            $this->tokenRepository->delete($token->id);
        }

        $date = new DateTimeImmutable();
        $token = $this->tokenizer->generate($email, $date);

        // Todo::лучше вынести в фоновые задачи
        $this->sender->send($token->code);
    }
}
