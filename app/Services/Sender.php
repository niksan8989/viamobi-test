<?php

namespace App\Services;

interface Sender
{
    public function send(string $code);
}
