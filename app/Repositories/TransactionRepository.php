<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository {
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Transaction::class;
    }
}
