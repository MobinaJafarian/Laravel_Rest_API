<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\RegisterResource;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {

    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'email' => 'required|email|min:3',
            'password' => 'required|string|min:8',
        ]);

        $auth = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'token' => Str::random(100),
        ]);

        $user = auth()->loginUsingId($auth->id);

        return new RegisterResource($user);
    }
}
