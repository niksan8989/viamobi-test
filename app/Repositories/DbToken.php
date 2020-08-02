<?php

namespace App\Repositories;

use App\Models\EmailToken;

class DbToken extends Base implements TokenRepository
{
    public function getModelClass(): string
    {
        return EmailToken::class;
    }

    public function findByEmail(string $email): ?EmailToken
    {
        return $this->model->where('email', $email)->first();
    }
}
