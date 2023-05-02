<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use lluminate\Http\Request\expectsJson;

class UserException extends Exception
{
    public function render($request)
    {
        return $request->expectsJson() ? new JsonResponse([
            'data' => [
                'message' => 'user is lock',
            ],
            'status' => 403,
        ], 403) : view('error');
    }
}
