<?php declare(strict_types=1);

namespace PhpAuthTool\Stores;

use PhpAuthTool\Contracts\NonceStore;
use Predis\Client;

class RedisNonceStore implements NonceStore
{
    private Client $redis;
    private string $prefix;

    public function __construct(Client $redis, string $prefix = 'nonce:')
    {
        $this->redis = $redis;
        $this->prefix = $prefix;
    }

    public function exists(string $nonce): bool
    {
        return $this->redis->exists($this->prefix . $nonce) > 0;
    }

    public function save(string $nonce, int $ttl = 30):void
    {
        $this->redis->setex($this->prefix . $nonce, $ttl, 1);
    }
}