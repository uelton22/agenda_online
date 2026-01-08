<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login');
        }

        // Check if client is active
        $client = Auth::guard('client')->user();
        if (!$client->is_active) {
            Auth::guard('client')->logout();
            return redirect()->route('client.login')
                ->with('error', 'Sua conta está desativada. Entre em contato com o suporte.');
        }

        return $next($request);
    }
}

