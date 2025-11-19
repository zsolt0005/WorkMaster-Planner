<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\CalendarEvent;
use App\Dto\DateEntry;
use App\Services\Router\Attributes\Get;
use DateMalformedStringException;
use DateTimeImmutable;
use Illuminate\Contracts\View\View;
use RuntimeException;

final class CalendarController extends AController
{
    #[Get('/', 'calendar')]
    public function default(): View
    {
        // TODO [WP-6] getTimePeriod should get the selected time period by user and return data accordingly
        $dayEntries = $this->getCalendarDayEntries();
        $events = $this->getEventsForDays($dayEntries);

        return view('calendar', [
            'dayEntries' => $dayEntries,
            'events' => $events
        ]);
    }

    /**
     * @return DateEntry[]
     */
    private function getCalendarDayEntries(): array
    {
        try {
            $today = new DateTimeImmutable('today');

            // ISO-8601: N = 1 (Mon) .. 7 (Sun)
            $isoDay = (int) $today->format('N');
            $monday = $today->modify(sprintf('-%d day', $isoDay - 1));

            $days = [];
            for ($i = 0; $i < 7; $i++) {
                $date = $monday->modify(sprintf('+%d days', $i));

                $days[] = new DateEntry($date, $today);
            }

            return $days;
        } catch (DateMalformedStringException $e) {
            throw new RuntimeException('Failed to get time period', previous: $e);
        }
    }

    /**
     * @param DateEntry[] $dayEntries
     *
     * @return CalendarEvent[]
     */
    private function getEventsForDays(array $dayEntries): array
    {

        return [
            new CalendarEvent('Event 1', $dayEntries[0]->dateTime->setTime(11, 00), $dayEntries[0]->dateTime->setTime(11, 30)),
            new CalendarEvent('Event 2', $dayEntries[0]->dateTime->setTime(11, 00), $dayEntries[0]->dateTime->setTime(11, 30)),
        ];
    }
}
