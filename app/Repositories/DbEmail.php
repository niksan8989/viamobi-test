<?php

namespace App\Repositories;

use App\Models\Email;

class DbEmail extends Base implements EmailRepository
{
    public function getModelClass(): string
    {
        return Email::class;
    }

    public function findByEmail(string $email): ?Email
    {
        return $this->model->where('email', $email)->first();
    }
}
