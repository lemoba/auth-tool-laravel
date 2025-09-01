<?php declare(strict_types=1);

namespace tests;

use PhpAuthTool\Contracts\NonceStore;
use PhpAuthTool\Services\Auth;
use PHPUnit\Framework\TestCase;

class MemoryNonceStore implements NonceStore {
    private $nonce = [];
    public function exists(string $nonce): bool {
        return isset($this->nonce[$nonce]);
    }
    public function save(string $nonce, int $ttl = 300): void {
        $this->nonce[$nonce] = time() + $ttl;
    }
}

final class AuthTest extends TestCase
{
    public function testGenerateAndVerify(): void
    {
        $store = new MemoryNonceStore();
        $auth = new Auth("test_secret", $store);

        $params = ["order_no" => "1001", "name" => 'ranen', 'city' => '杭州'];
        $signed = $auth->generate($params);

        $this->assertTrue($auth->verify($signed));
        $this->assertFalse($auth->verify($signed));
    }
}