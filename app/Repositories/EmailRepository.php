<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Email as EmailModel;

interface EmailRepository
{
    public function getModelClass(): string;
    public function findByEmail(string $email): ?EmailModel;
}
