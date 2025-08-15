<?php

namespace App\Exceptions;

use Exception;

class InvalidOrderException extends Exception
{
    public function render($message = "Invalid order", $code = 0, Exception $previous = null)
    {
        return response()->json([
            'error' => 'InvalidOrderException'
        ], 422);
    }
}
