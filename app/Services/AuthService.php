<?php

namespace App\Services;


use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService extends BaseService
{
    public function __construct(protected AuthRepository $authRepository) {
        parent::__construct($authRepository);
    }

    public function login(array $credentials): array
    {
        $user = $this->first('email','=',$credentials['email']);
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(): void
    {
        Auth::user()?->tokens()->delete();
    }
}
