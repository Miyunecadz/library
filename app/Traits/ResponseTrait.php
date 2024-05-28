<?php

namespace App\Traits;

trait ResponseTrait
{
  protected function successResponse($data = [], $message = 'Success', $statusCode = 200)
  {
    return response()->json([
      'success' => true,
      'message' => $message,
      'data' => $data
    ], $statusCode);
  }

  protected function failedResponse($message = 'Failed', $errors = [], $statusCode = 400)
  {
    return response()->json([
      'success' => false,
      'message' => $message,
      'errors' => $errors
    ], $statusCode);
  }
}
