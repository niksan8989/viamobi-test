<?php

namespace App\Services;

use App\Models\EmailToken;

class Tokenizer
{
    public $interval;

    public function __construct(\DateInterval $interval)
    {
        $this->interval = $interval;
    }

    public function generate($email, $date)
    {
        return EmailToken::create([
           'email' => $email,
           'code' => rand(1000, 9999),
           'expires' => $date->add($this->interval)
        ]);
    }
}
