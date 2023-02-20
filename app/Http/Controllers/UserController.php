<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class UserController extends Controller
{
    public function register(Request $request)
    : \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $fields = $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        $implodedData = implode("', '", $fields);
        $result = DB::select("CALL sp_register_new_user('" . $implodedData . "')");
        return response($result, 201);
    }

    public function login(Request $request)
    : \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $fields = $request->validate([
            'username' => 'string',
            'email' => 'string',
            'password' => 'required|string'
        ]);

        $implodedData = implode("', '", $fields);
        $result = DB::select("CALL sp_log_in('" . $implodedData . "')");
        return response($result, 201);
    }

    #[ArrayShape(['message' => "string"])]
    public function logout(): array
    {
        $token = request()->bearerToken();
        DB::select("CALL sp_log_out('". $token ."')");
        return [
            'message' => 'Logged out'
        ];
    }

}
