<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Store\StoreUserRequest;
use App\Http\Services\AuthService;
use Exception;

class AuthController extends BaseController {
    public function __construct(private AuthService $authService) {
    }

    public function register(StoreUserRequest $request) {
        try {
            $payload = $request->validated();

            $data = $this->authService->register($payload);

            return $this->jsonResponse($data, 'User account created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }

    public function login(LoginRequest $request) {
        try {
            $payload = $request->validated();

            $data = $this->authService->login($payload);

            return $this->jsonResponse($data, 'User logged in successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }

    public function logout() {
        try {
            $data = $this->authService->logout();

            return $this->jsonResponse($data, 'Logout successful');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }
}
