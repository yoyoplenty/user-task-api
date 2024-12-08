<?php

namespace App\Repositories;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository extends BaseRepository {
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return User::class;
    }

    public function findByEmailOrUserName(string $value): User {
        $user = $this->model->where('username', $value)
            ->orWhere('email', $value)->first();

        if (!$user) throw new NotFoundHttpException("user not found");

        return $user;
    }
}
