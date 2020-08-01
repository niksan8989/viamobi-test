<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;
use RuntimeException;

class EmailThrottle extends ThrottleRequests
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        if ($email = $request->get('email')) {
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
