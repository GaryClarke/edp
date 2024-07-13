<?php

declare(strict_types=1);

namespace App\Error;

use Throwable;

class DebugErrorHandler implements ErrorHandlerInterface
{
    public function handle(Throwable $error): void
    {
        dump('DebugErrorHandler');
        throw $error;
    }
}
