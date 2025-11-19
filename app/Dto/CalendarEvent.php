<?php declare(strict_types=1);

namespace App\Dto;

final class CalendarEvent
{
    public function __construct(
        public string $name,
        public string $time,
    )
    {
    }
}
