<?php declare(strict_types=1);

return [
    'secret' => env('AUTH_TOOL_SECRET', 'test_secret'),
    'nonce_prefix' => env('AUTH_TOOL_NONCE_PREFIX', 'auth_nonce:'),
];