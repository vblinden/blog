<?php

namespace App\Support;

use Illuminate\Http\Request;

class PennyMetrics
{
    public static function upstreamHeaders(Request $request): array
    {
        $strip = [
            'host', 'connection', 'content-length', 'content-encoding',
            'transfer-encoding', 'keep-alive', 'cookie',
        ];

        $headers = [];

        foreach ($request->headers->all() as $key => $values) {
            if (! in_array(strtolower($key), $strip, true)) {
                $headers[$key] = $values[0] ?? '';
            }
        }

        $clientIp = $request->header('CF-Connecting-IP')
            ?: trim(explode(',', (string) $request->header('X-Forwarded-For'))[0] ?: '')
            ?: $request->ip();

        if ($clientIp) {
            $headers['X-PM-Client-IP'] = $clientIp;
        }

        return $headers;
    }
}
