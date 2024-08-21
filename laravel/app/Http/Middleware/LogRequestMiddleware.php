<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // リクエストパスとパラメータをログ出力
        $filteredParams = $this->filterSensitiveData($request->all());
        $logMessage = sprintf(
            'Request Path: %s | Request Parameters: %s',
            $request->path(),
            json_encode($filteredParams)
        );

        Log::debug($logMessage);

        return $next($request);
    }

    /**
     * データをマスキング
     */
    protected function filterSensitiveData(array $params): array
    {
        // フィルタリングしたいキー
        $sensitiveKeys = ['password', 'card_number', 'cvv'];

        foreach ($sensitiveKeys as $key) {
            if (isset($params[$key])) {
                $params[$key] = str_repeat('*', strlen($params[$key]));
            }
        }

        return $params;
    }
}
