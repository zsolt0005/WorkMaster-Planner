<?php declare(strict_types=1);

namespace App\Services\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Middleware
{
    public function __construct(public string $name)
    {
    }
}
