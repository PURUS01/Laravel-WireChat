<?php

namespace App\Http\Middleware;

use App\Services\Wirechat\EnsureGeneralConversation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGeneralWirechatAccess
{
    public function __construct(
        protected EnsureGeneralConversation $ensureGeneralConversation
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $this->ensureGeneralConversation->forUser($user);
        }

        return $next($request);
    }
}
