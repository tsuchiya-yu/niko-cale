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
        // リクエストパス、パラメータ、HTTPメソッド、ユーザーエージェント、IPアドレスをログ出力
        $filteredParams = $this->filterSensitiveData($request->all());
        $logMessage = sprintf(
            'Method: %s | Path: %s | Parameters: %s | UA: %s | IP: %s',
            $request->method(),
            $request->path(),
            json_encode($filteredParams),
            $request->header('User-Agent'),
            $request->header('X-Forwarded-For', $request->ip())
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
