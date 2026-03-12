<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class UptimeCheckService {
    public function checkDomain($domain) {
        try {
            $start = microtime(true);
            $response = Http::timeout(10)
                ->withoutRedirecting()
                ->retry(3, 1000)
                ->head('https://'.$domain);

            $httpStatus = $response->status();

            $status = $httpStatus < 500 ? 'OK' : 'FAIL';

            $error = null;
            $responseTimeMs = round((microtime(true) - $start) * 1000);


        } catch (\Throwable $e) {

            $httpStatus = null;
            $status = 'FAIL';
            $error = $e->getMessage();
            $responseTimeMs = null;
        }

        return [
            'status' => $status,
            'http_status' => $httpStatus,
            'error' => $error,
            'response_time_ms' => $responseTimeMs
        ];
    }
}