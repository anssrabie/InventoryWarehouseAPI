<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Store a newly created resource in storage.
     */
    public function login(LoginRequest $request)
    {
        $loginData = $this->authService->login($request->validated());
        return $this->returnData([
            'user' => new UserResource($loginData['user']),
            'token' => $loginData['token'],
        ], 'You have successfully logged in.',201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout()
    {
        $this->authService->logout();
        return $this->successMessage('You have successfully logged out.');
    }
}
