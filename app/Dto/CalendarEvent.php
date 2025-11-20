<?php declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;
use Throwable;

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
        try {
            // Day boundaries for the day being rendered
            $dayStart = $actualDay->setTime(0, 0, 0);
            $dayEnd = $dayStart->modify('+1 day');

            // Clip event start to this day
            $effectiveStart = $this->dateTimeFrom < $dayStart ? $dayStart : $this->dateTimeFrom;
            $effectiveEnd = min($this->dateTimeTo, $dayEnd);

            // If the clipped event does not intersect this day, -1 means "no intersection with the current day (Should never happen)"
            if ($effectiveEnd <= $dayStart || $effectiveStart >= $dayEnd) {
                return -1;
            }

            return (int) floor(($effectiveStart->getTimestamp() - $dayStart->getTimestamp()) / 60);
        } catch (Throwable $e) {
            return -1; // Should never happen, but just in case
        }
    }

    public function getLengthOffset(DateTimeImmutable $actualDay): int
    {
        try {
            $dayStart = $actualDay->setTime(0, 0, 0);
            $dayEnd = $dayStart->modify('+1 day');

            // Clip event to this day
            $effectiveStart = $this->dateTimeFrom < $dayStart ? $dayStart : $this->dateTimeFrom;
            $effectiveEnd = min($this->dateTimeTo, $dayEnd);

            // No overlap with this day
            if ($effectiveEnd <= $dayStart || $effectiveStart >= $dayEnd) {
                return 0;
            }

            $lengthInMinutes = (int) floor(($effectiveEnd->getTimestamp() - $effectiveStart->getTimestamp()) / 60);

            // Ensure at least 1 minute if there's any overlap at all
            return max(0, $lengthInMinutes);
        } catch (Throwable $e) {
            return -1; // Should never happen, but just in case
        }
    }
}
