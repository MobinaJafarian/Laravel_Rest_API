<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\UserException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::query()->limit(1)->first();
        $users = User::all();
        // throw new UserException();
        return new UserResource($users);    
    }
}
