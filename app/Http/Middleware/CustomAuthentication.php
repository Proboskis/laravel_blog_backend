<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
//        $token = $request->header('Authorization');
        $token = request()->bearerToken();
        $result = DB::select("CALL sp_token_comparator('".$token."')");
        $result = $result[0]->token;
        if ($token != $result) {
            return response([
                'message' => 'Something went wrong, please log in again ...'
            ], 404);
        }
        return $next($request);
    }
}
