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

    public function getStartPosition(DateTimeImmutable $actualDay): int
    {
        $hour = (int) $this->dateTimeFrom->format('H');
        $minute = (int) $this->dateTimeFrom->format('i');

        return ($hour * 60) + $minute;
    }

    public function getLengthOffset(DateTimeImmutable $actualDay): int
    {
        $interval = $this->dateTimeTo->diff($this->dateTimeFrom);

        return ($interval->h * 60) + $interval->i;
    }
}
