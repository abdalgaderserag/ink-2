<?php

namespace App\Traits;

trait EditControllerTrait
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['edit', 'update', 'delete', 'store']);
    }
}