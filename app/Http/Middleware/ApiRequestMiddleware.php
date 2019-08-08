<?php

namespace App\Http\Middleware;


class ApiRequestMiddleware extends Authenticate
{
    public function authenticate()
    {
        return $this->auth->shouldUse('api');
    }
}
