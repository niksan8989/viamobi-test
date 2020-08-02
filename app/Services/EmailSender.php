<?php

namespace App\Services;

use App\Repositories\Token;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

class EmailSender
{
    /**
     * @var Tokenizer
     */
    private $tokenizer;
    /**
     * @var Token
     */
    private $repository;
    /**
     * @var Sender
     */
    private Sender $sender;

    public function __construct(
        Tokenizer $tokenizer,
        Token $repository,
        Sender $sender
    )
    {
        $this->tokenizer = $tokenizer;
        $this->repository = $repository;
        $this->sender = $sender;
    }

    public function send($email)
    {
        Assert::email($email);

        if ($token = $this->repository->findByEmail($email)) {
            $this->repository->delete($token->id);
        }

        $date = new DateTimeImmutable();
        $token = $this->tokenizer->generate($email, $date);

        // Todo::лучше вынести в фоновые задачи
        $this->sender->send($token->code);
    }
}
