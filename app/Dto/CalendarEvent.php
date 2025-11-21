<?php declare(strict_types=1);

namespace App\Dto;

use App\Models\Event;
use DateTimeImmutable;
use Throwable;

final class CalendarEvent
{
    public readonly DateTimeImmutable $dateTimeFrom;
    public readonly DateTimeImmutable $dateTimeTo;

    public function __construct(public Event $event)
    {
        $this->dateTimeFrom = $this->event->getStartDateTime();
        $this->dateTimeTo = $this->event->getEndDateTime();
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

    public function getBackgroundColor(float $opacity): Rgba
    {
        return $this->hexToRgb($this->event->eventType->background_color, $opacity);
    }

    public function getTextColor(float $opacity): Rgba
    {
        return $this->hexToRgb($this->event->eventType->text_color, $opacity);
    }

    private function hexToRgb(string $hexColor, float $opacity = 1): Rgba
    {
        $hex = ltrim($hexColor, '#');

        if (strlen($hex) === 3) {
            // Expand short form (#f60 -> #ff6600)
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        $r = (int) hexdec(substr($hex, 0, 2));
        $g = (int) hexdec(substr($hex, 2, 2));
        $b = (int) hexdec(substr($hex, 4, 2));

        return new Rgba($r, $g, $b, $opacity);
    }
}
