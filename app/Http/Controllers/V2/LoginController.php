<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\LoginResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {

    }

    public function login(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'required|email|exists:users,email|min:3',
            'password' => 'required|string|min:3',
        ]);

        if (! auth()->attempt($data)) {
            return response([
                'data' => [
                    'message' => 'invalid data',
                    'status' => 'error'
                ],
            ], Response::HTTP_FORBIDDEN);
        }

        return new LoginResource(auth()->user());
    }
}
