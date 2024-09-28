<?php

namespace App\Http\Controllers\Users;

use function password_verify;
use App\Models\User;
use Framework\Support\Facades\Response;
use Framework\Support\Facades\Router;
use Framework\Support\Facades\Session;
use Framework\Support\Facades\Validation;

class LogInUserController
{
    public function handle()
    {
        secure();

        $data = Validation::validate($_POST, [
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:10'],
        ], 'login_errors');

        $user = User::where('email', $data['email'])->first();

        if ($user && password_verify($data['password'], $user->password)) {
            Session::put('user_id', $user->id);
        }

        return Response::redirect(Router::route('show-home-page'));
    }
}
