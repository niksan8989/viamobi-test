<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{
    public $timestamps = false;
    protected $table = 'email_tokens';
    protected $dates = ['expires'];

    private const MAX_ATTEMPTS = 3;

    protected $fillable = [
        'email',
        'code',
        'expires',
    ];

    public function validate(int $value, \DateTimeImmutable $date): void
    {
        if ($this->isAttemptLimitExceeded()) {
            throw new \DomainException("Было совершено 3 неудачных попытки входа. Необходимо сгенерировать код заново");
        }

        if (!$this->isEqualTo($value)) {
            throw new \DomainException("Некорректный код");
        }

        if ($this->isExpired($date)) {
            throw new \DomainException("Время жизни токена истекло");
        }
    }

    public function isEqualTo($value): bool
    {
        return $this->code === $value;
    }

    public function isExpired(\DateTimeImmutable $date): bool
    {
        return $date >= $this->expires;
    }

    public function isAttemptLimitExceeded()
    {
        return $this->attempt > self::MAX_ATTEMPTS;
    }

    public function attempt()
    {
        $this->update(['attempt' => $this->attempt++]);
    }

}
