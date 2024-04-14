<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Log;

class GlobalExceptionHandler
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (Exception $e) {
            Log::error('Caught exception: ' . $e->getMessage());
            return response()->json(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
    }
}
