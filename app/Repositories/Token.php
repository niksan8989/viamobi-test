<?php

namespace App\Repositories;

use App\Models\EmailToken;
use Illuminate\Database\Eloquent\Model;

interface Token
{
    public function findById($id): ?Model;
    public function delete(int $id): void;
    public function getModelClass(): string;
    public function findByEmail(string $email): ?EmailToken;
}
