<?php

namespace App\Http\Services;

use App\Repositories\UserRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserService {

    public function __construct(
        private UserRepository $user,
    ) {
    }

    public function find() {
        $users = $this->user->with(['wallet'])->findAll();

        return $users;
    }

    public function findById(int $id) {
        $user = $this->user->with(['wallet'])->find($id);

        return $user;
    }

    public function delete(int $id) {
        $user = $this->user->find($id);
        if (!$user) throw new BadRequestHttpException("user not found.");

        $user->delete();

        return null;
    }
}
