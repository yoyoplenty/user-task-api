<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shared\TransferFundRequest;
use App\Http\Services\Api\WalletService;
use Exception;

class WalletController extends BaseController {

    public function __construct(private WalletService $walletService) {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function transfer(TransferFundRequest $request) {
        try {
            $payload = $request->validated();

            $data = $this->walletService->transfer($payload);

            return $this->jsonResponse($data, 'Transfer successful');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }
}
