<?php

declare(strict_types=1);

namespace App\Error;

use App\DTO\Webhook;
use Throwable;

class ErrorHandler
{
    public function handle(Throwable $error): void
    {
        // Log to centralized logging platform e.g. DataDog
    }
}
