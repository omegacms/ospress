<?php

namespace App\Http\Controllers\Users;

use Framework\Support\Facades\Response;
use Framework\Support\Facades\Router;
use Framework\Support\Facades\Session;

class LogOutUserController
{
    public function handle()
    {
        Session::forget('user_id');

        return Response::redirect(Router::route('show-home-page'));
    }
}
