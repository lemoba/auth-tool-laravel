<?php declare(strict_types=1);

namespace PhpAuthTool\Contracts;

interface NonceStore
{
    public function exists(string $nonce): bool;
    public function save(string $nonce, int $ttl = 300): void;
}