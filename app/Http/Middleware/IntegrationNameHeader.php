<?php

namespace App\Http\Middleware;

use Closure;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IntegrationNameHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->hasHeader('X-Integration-Name')) {
            throw new InvalidArgumentException(
                message: 'The X-Integration-Name header is required.',
                code: Response::HTTP_BAD_REQUEST
            );
        }
        return $next($request);
    }
}
