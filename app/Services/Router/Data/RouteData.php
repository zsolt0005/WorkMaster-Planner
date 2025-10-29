<?php declare(strict_types=1);

namespace App\Services\Router\Data;

class RouteData
{
    /**
     * @param class-string $class
     */
    public function __construct(
        public string $class,
        public string $method,
        public string $requestMethod,
        public string $path,
        public string $name,
    ) {
    }
}
