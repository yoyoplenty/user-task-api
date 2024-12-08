<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Transaction extends Model {
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, FilterQueryString;

    /**
     * Get the wallet associated with the transaction.
     */
    public function wallet(): BelongsTo {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the related wallet for this transaction (for transfers).
     */
    public function relatedWallet(): BelongsTo {
        return $this->belongsTo(Wallet::class, 'related_wallet_id');
    }
}
