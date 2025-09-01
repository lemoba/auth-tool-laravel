<?php declare(strict_types=1);

namespace PhpAuthTool\Services;

use PhpAuthTool\Contracts\NonceStore;
use PhpAuthTool\Support\Signer;

class Auth
{
    private string $secret;
    private NonceStore $nonceStore;
    private int $ttl;

    public function __construct(string $secret, NonceStore $nonceStore, int $ttl = 300)
    {
        $this->secret = $secret;
        $this->nonceStore = $nonceStore;
        $this->ttl = $ttl;
    }

    public function generate(array $params): array
    {
        $params['nonce'] = bin2hex(random_bytes(8));
        $params['timestamp'] = time();
        $params['sign'] = Signer::sign($params, $this->secret);

        return $params;
    }

    public function verify(array $params)
    {
        $sign = $params['sign'] ?? '';
        $nonce = $params['nonce'] ?? '';
        $timestamp = $params['timestamp'] ?? 0;

        if (!$sign || !$nonce || !$timestamp) return false;

        $copyParams = $params;

        unset($copyParams['sign']);

        if (abs(time() - intval($timestamp)) > $this->ttl) return false;

        if (!Signer::verify($copyParams, $this->secret, $sign)) return false;

        if ($this->nonceStore->exists($nonce)) return false;

        $this->nonceStore->save($nonce, $this->ttl);

        return true;
    }
}