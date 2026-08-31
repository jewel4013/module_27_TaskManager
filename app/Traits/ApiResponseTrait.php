<?php
namespace App\Traits;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function success(mixed $data = null, string $massage = '', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $massage,
        ], $status);
    }

    protected function error(array $massage = ['Internal Server Error'], int $status = 500): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $massage,
        ], $status);
    }    
}
