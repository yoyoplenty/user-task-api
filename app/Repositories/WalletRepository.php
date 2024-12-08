<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository extends BaseRepository {
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Wallet::class;
    }
}
