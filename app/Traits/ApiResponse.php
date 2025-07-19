<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    protected static int $defaultCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public static function getDefaultErrorCode(): int
    {
        return static::$defaultCode;
    }
    /**
     * Format the API response.
     *
     * @param bool $status
     * @param string $message
     * @param array|object $data
     * @param int $code
     * @return JsonResponse
     */
    private function formatResponse(bool $status, string $message = '', array|object $data = [], int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status,
            'code' => $code,
        ], $code);
    }

    /**
     * Return a success response with data.
     *
     * @param object|array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function returnData(object|array $data = [], string $message = 'success', int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->formatResponse(true, $message, $data, $code);
    }

    /**
     * Return a success response with only a message.
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function successMessage(string $message = '', int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->formatResponse(true, $message, [], $code);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorMessage(string $message, ?int $code = null): JsonResponse
    {
        $code ??= self::getDefaultErrorCode();
        return $this->formatResponse(false, $message, [], $code);
    }
}
