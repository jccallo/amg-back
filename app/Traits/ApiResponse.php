<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{

    public function successResponse($data, $code = Response::HTTP_OK)
    {
        $response = ['success' => true];
        // var_dump($data);
        if ($data instanceof LengthAwarePaginator) {
            $response['data'] = $data->items();
        }
        else $response['data'] = $data;

        return response()->json($response, $code);
    }

    /**
     * Build error response
     * @param  string|object|array $message
     * @param  int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = [
            'success' => false,
            'error' => $message,
        ];

        return response()->json($response, $code);
    }
}
