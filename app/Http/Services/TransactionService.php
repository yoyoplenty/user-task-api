<?php

namespace App\Http\Services\Api;

use App\Repositories\TransactionRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TransactionService {
    public function __construct(
        private TransactionRepository $transaction,
    ) {
    }

    public function find() {
        $transactions = $this->transaction->findAll();

        return $transactions;
    }

    public function findById(int $id) {
        $transaction = $this->transaction->with([])->findById($id);

        return $transaction;
    }

    public function update(int $id, array $payload) {
        $transaction = $this->transaction->find($id);
        if (!$transaction) throw new BadRequestHttpException("transaction not found.");

        $transaction->update($payload);

        return $transaction;
    }

    public function delete(int $id) {
        $transaction = $this->transaction->find($id);
        if (!$transaction) throw new BadRequestHttpException("transaction not found.");

        $transaction->delete();

        return null;
    }
}
