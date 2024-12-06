<?php

namespace App\Http\Controllers\api;

use App\helpers\SendResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Services\UserService;

class AuthController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function register(Request $request)
    {
        return $this->userService->registerUser($request);

    }
    public function login(Request $request)
    {
        return $this->userService->loginUser($request);
    }
    public function logout(Request $request)
    {
        return $this->userService->logoutUser($request);
    }

}
