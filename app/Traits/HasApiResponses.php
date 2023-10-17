<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait HasApiResponses
{
    /**
     * Generating success API response.
     */
    public static function success(string $message = 'SUCCESS', mixed $data = null, int $code = Response::HTTP_OK): JsonResponse
    {
        $code = $code === null || !$code ? Response::HTTP_OK : $code;

        $response['message'] = $message;
        $response['data'] = $data;

        return response()->json($response, $code);
    }

    /**
     * Generating failed API response.
     */
    public static function failed(string $message = 'FAILED', mixed $errors = null, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $code = $code === null || !$code ? Response::HTTP_BAD_REQUEST : $code;

        $response['message'] = $message;
        $response['errors'] = $errors;

        $response = response()->json($response, $code);

        throw new HttpResponseException($response);
    }
}
