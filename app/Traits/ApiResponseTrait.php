<?php
namespace App\Traits;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function success(mixed $data = null, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'messages' => $message,
        ], $code);
    }

    protected function error(array $message = ['Internal Server Error'], int $code = 500): JsonResponse
    {
        return response()->json([
            'status' => false,
            'messages' => $message,
        ], $code);
    }    
}
