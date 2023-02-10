<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class CustomAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        if (($path == 'login' || $path == 'register') &&
        (Session::get('user'))) {
            return redirect('/');
        } else if (($path != 'login' && !Session::get('user') ||
            $path != 'register' && !Session::get('user'))) {
            return redirect('/api/login');
        } else {
            return $next($request);
        }
    }
}
