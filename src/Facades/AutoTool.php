<?php declare(strict_types=1);

namespace PhpAuthTool\Facades;

use Illuminate\Support\Facades\Facade;

class AutoTool extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'auto-tool';
    }
}