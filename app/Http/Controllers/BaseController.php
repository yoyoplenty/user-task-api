<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller {
    use AuthorizesRequests, ValidatesRequests;

    /**
     * General success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function jsonResponse($data, $message = 'Successfully fetched data', $code = 200) {
        $response = [
            'message' => $message,
            'status' => true,
            'data'    => $data,
        ];

        return response()->json($response, $code);
    }

    /**
     * General error response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function jsonError($error = 'An error occurred', $code = 422) {
        $response = [
            'error' => $error,
            'status' => false,
            'data' =>  null,
        ];

        return response()->json($response, $code);
    }
}
