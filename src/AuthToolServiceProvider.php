<?php declare(strict_types=1);

namespace PhpAuthTool;

use Illuminate\Support\ServiceProvider;
use PhpAuthTool\Services\Auth;
use PhpAuthTool\Stores\RedisNonceStore;

class AuthToolServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/authtoool.php', 'authtool');

        $this->app->singleton(Auth::class, function ($app) {
            $config = $app['config']['authtoool'];
            $store = new RedisNonceStore($app['redis']->connection(), $config['nonce_prefix']);

            return new Auth($config['secret'], $store);
        });

        $this->app->alias(Auth::class, 'auth-tool');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '../config/authtool.php' => config_path('authtool.php'),
        ], 'config');
    }
}