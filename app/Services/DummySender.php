<?php

namespace App\Services;

class DummySender implements Sender
{
    public function send(string $code) {
        return true;
    }
}
