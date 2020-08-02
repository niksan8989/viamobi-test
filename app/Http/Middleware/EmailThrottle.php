<?php

namespace App\Http\Middleware;

use App\Repositories\EmailRepository;
use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Routing\Middleware\ThrottleRequests;
use RuntimeException;

class EmailThrottle extends ThrottleRequests
{
    /**
     * @var EmailRepository
     */
    private EmailRepository $emailRepository;

    public function __construct(EmailRepository $emailRepository, RateLimiter $limiter)
    {
        $this->emailRepository = $emailRepository;
        parent::__construct($limiter);
    }

    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        $email = $request->get('email');

        if ($email && !$this->emailRepository->findByEmail($email)) {
            $key = $prefix . $this->resolveRequestSignatureByEmail($email);

            $maxAttempts = $this->resolveMaxAttempts($request, $maxAttempts);

            if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
                throw $this->buildException($key, $maxAttempts);
            }

            $this->limiter->hit($key, $decayMinutes * 60);

            $response = $next($request);

            return $this->addHeaders(
                $response, $maxAttempts,
                $this->calculateRemainingAttempts($key, $maxAttempts)
            );
        }

        return $next($request);
    }

    private function resolveRequestSignatureByEmail($email)
    {
        return sha1($email);
    }
}
