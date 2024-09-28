<?php

namespace App\Http\Controllers\Users;

use Framework\Support\Facades\Router;

class ShowRegisterFormController
{
    public function handle()
    {
        return view('users/register', [
            'registerAction' => Router::route('register-user'),
            'logInAction'    => Router::route('log-in-user'),
            'csrf'           => csrf(),
        ]);
    }
}
