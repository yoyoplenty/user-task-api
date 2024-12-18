<?php

namespace App\Http\Services;

use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService {

    public function __construct(
        private UserRepository $user,
        private WalletRepository $wallet,
    ) {
    }

    public function register(array $payload) {
        $location = Location::get();

        if (!$location || $location->countryCode !== 'NG')
            throw new BadRequestHttpException("Registration is restricted to only nigerians");

        $payload['password'] = Hash::make($payload['password']);

        $user = $this->user->create($payload);

        $this->wallet->create([
            'user_id' => $user->id
        ]);

        return $user;
    }

    public function login(array $payload) {
        $value = $payload['value'] ?? null;
        $password = $payload['password'] ?? null;

        $user = $this->user->findByEmailOrUserName($value);
        if (!Hash::check($password, $user->password))
            throw new BadRequestHttpException("Password is incorrect.");

        $token = JWTAuth::fromUser($user);

        return [...$user->toArray(), 'token' => $token];
    }

    public function logout() {
        $token = Auth::getToken();
        if ($token) Auth::setToken($token)->invalidate();

        return null;
    }
}
