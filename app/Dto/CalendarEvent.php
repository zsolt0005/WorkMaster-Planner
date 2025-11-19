<?php declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;

final class CalendarEvent
{
    public function __construct(
        public string $name,

        public DateTimeImmutable $dateTimeFrom,
        public DateTimeImmutable $dateTimeTo,
    )
    {
    }
}
