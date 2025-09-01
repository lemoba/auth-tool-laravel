<?php declare(strict_types=1);

namespace PhpAuthTool\Support;

class Signer
{
    public static function sign(array $params, string $secret): string
    {
        ksort($params);

        $raw = http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        return hash_hmac('sha256', $raw, $secret);
    }

    public static function verify(array $params, string $secret, string $sign): bool
    {
        $calculated = self::sign($params, $secret);

        return hash_equals($calculated, $sign);
    }
}