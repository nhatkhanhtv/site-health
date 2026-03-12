<?php 
namespace App\Services;

use Carbon\Carbon;

class SSLCheckService
{
    public function check(string $domain): array
    {
        try {
            $context = stream_context_create([
                "ssl" => [
                    "capture_peer_cert" => true,
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ]
            ]);

            $client = stream_socket_client(
                "ssl://{$domain}:443",
                $errno,
                $errstr,
                30,
                STREAM_CLIENT_CONNECT,
                $context
            );

            if (!$client) {
                return [
                    'site' => $domain,
                    'expiry' => null,
                    'id_valid' => false,
                    'issuer' => null,
                    'error' => "$errno: $errstr"
                ];
            }

            $params = stream_context_get_params($client);
            $cert = $params["options"]["ssl"]["peer_certificate"];

            $certInfo = openssl_x509_parse($cert);
            $expiry = Carbon::createFromTimestamp($certInfo['validTo_time_t']);
            $daysLeft = now()->diffInDays($expiry, false);

            $status = 'OK';
            if($certInfo['issuer']['O']) {
                $issuer = $certInfo['issuer']['O'];
            } else {
                $issuer = null;
            }

            return [
                'site' => $domain,
                'expiry' => $expiry->toDateTimeString(),
                'days_left' => $daysLeft,
                'id_valid' => true,
                'issuer' => $issuer,
                'error' => null
            ];
        } catch (\Throwable $e) {
            return [
                'site' => $domain,
                'expiry' => null,
                'id_valid' => false,
                'issuer' => null,
                'error' => $e->getMessage()
            ];
        }
    }
}