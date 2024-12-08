<?php

namespace App\Http\Controllers;

use App\Http\Services\Api\UserService;
use Exception;

class UserController extends BaseController {

    public function __construct(private UserService $userService) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        try {
            $data = $this->userService->find();

            return $this->jsonResponse($data, 'user fetched successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id) {
        try {
            $data = $this->userService->findById($id);

            return $this->jsonResponse($data, 'user fetched successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) {
        try {
            $data = $this->userService->delete($id);

            return $this->jsonResponse($data, 'user deleted successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 400);
        }
    }
}
