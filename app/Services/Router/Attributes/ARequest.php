<?php declare(strict_types=1);

namespace App\Services\Router\Attributes;

abstract class ARequest
{
    public string $method;

    public function __construct(
        public string $path,
        public string $name
    ) {
    }
}
