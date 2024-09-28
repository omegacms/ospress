<?php

namespace App\Http\Controllers\Users;

use function password_hash;
use App\Models\User;
use Framework\Support\Facades\Queue;
use Framework\Support\Facades\Response;
use Framework\Support\Facades\Router;
use Framework\Support\Facades\Session;
use Framework\Support\Facades\Validation;

class RegisterUserController
{
    public function handle()
    {
        secure();

        $data = Validation::validate($_POST, [
            'name'     => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:10'],
        ], 'register_errors');

        $user           = new User();
        $user->name     = $data['name'];
        $user->email    = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->save();

        Session::put('registered', true);

        Queue::push(function($user) {
            // send a mail to the user...
        }, $user);

        return Response::redirect(Router::route('show-home-page'));
    }
}
