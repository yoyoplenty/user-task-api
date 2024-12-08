<?php

namespace App\Http\Services\Api;

use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WalletService {

    public function __construct(
        private UserRepository $user,
        private WalletRepository $wallet,
        private TransactionRepository $transaction,
    ) {
    }

    public function transfer(array $payload) {
        $username  = $payload['username'];
        $amount  = $payload['amount'];

        $senderWallet = Auth::user()->wallet;

        $receiver = $this->user->findWhere(['username' => $username])->first();
        $receiverWallet = $receiver->wallet;

        if ($senderWallet->balance < $amount)
            throw new BadRequestHttpException("Insufficient balance to transfer funds");

        DB::transaction(function () use ($senderWallet, $receiverWallet, $amount) {
            $senderWallet->decrement('balance', $amount);
            $receiverWallet->increment('balance', $amount);

            $reference = uniqid('txn_', true);

            $this->logTransaction($senderWallet->id, 'debit', $amount, $receiverWallet->id, $reference);
            $this->logTransaction($receiverWallet->id, 'credit', $amount, $senderWallet->id, $reference);
        });

        return null;
    }

    private function logTransaction(int $walletId, string $type, float $amount, int $relatedWalletId, string $reference): void {
        $this->transaction->create([
            'wallet_id' => $walletId,
            'type' => $type,
            'amount' => $amount,
            'reference' => $reference,
            'related_wallet_id' => $relatedWalletId,
        ]);
    }
}
