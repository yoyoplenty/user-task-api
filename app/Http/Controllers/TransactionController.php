<?php

namespace App\Http\Controllers;

use App\Http\Requests\Update\UpdateTransactionRequest;
use App\Http\Services\TransactionService;
use Exception;

class TransactionController extends BaseController {

    public function __construct(private TransactionService $transactionService) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {
        try {
            $data = $this->transactionService->find();

            return $this->jsonResponse($data, 'transaction fetched successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id) {
        try {
            $data = $this->transactionService->findById($id);

            return $this->jsonResponse($data, 'transaction fetched successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateTransactionRequest $request) {
        try {
            $payload = $request->validated();

            $data = $this->transactionService->update($id, $payload);

            return $this->jsonResponse($data, 'transaction updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) {
        try {
            $data = $this->transactionService->delete($id);

            return $this->jsonResponse($data, 'transaction deleted successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }
}
