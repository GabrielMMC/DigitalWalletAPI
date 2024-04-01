<?php

namespace App\Utils;

class ExceptionHandler
{
  public static function handle(\Exception $e)
  {
    return response()->json([
      'message' => $e->getMessage(),
      'debug' => [
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
      ]
    ], 500);
  }
}
