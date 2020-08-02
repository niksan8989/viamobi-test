<?php

namespace App\Repositories;

use App\Models\EmailToken;

interface TokenRepository
{
    public function delete(int $id): void;
    public function getModelClass(): string;
    public function findByEmail(string $email): ?EmailToken;
}
