<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\CalendarEvent;
use App\Dto\DateEntry;
use App\Services\Router\Attributes\Get;
use DateMalformedStringException;
use DateTimeImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use RuntimeException;

final class CalendarController extends AController
{
    private const array VIEW_TYPES = ['month', 'week', 'day'];

    private const string DEFAULT_VIEW_TYPE = 'week';

    #[Get('/', 'calendar')]
    public function default(Request $request): View
    {
        $viewType = $this->getViewType($request);

        $dayEntries = $this->getCalendarDayEntries($viewType);
        $events = $this->getEventsForDays($dayEntries);

        return view('calendar', [
            'viewType' => $viewType,
            'dayEntries' => $dayEntries,
            'events' => $events,
        ]);
    }

    /**
     * @return DateEntry[]
     */
    private function getCalendarDayEntries(string $viewType): array
    {
        try {
            $today = new DateTimeImmutable('today');

            switch ($viewType) {
                case 'day':
                    $startDate = $today;
                    $daysCount = 1;
                    break;

                case 'month':
                    $startDate = $today->modify('first day of this month');
                    $daysCount = (int) $today->format('t');
                    break;

                case 'week':
                default:
                    $isoDay = (int) $today->format('N');
                    $startDate = $today->modify(sprintf('-%d day', $isoDay - 1));
                    $daysCount = 7;
                    break;
            }

            $days = [];
            for ($i = 0; $i < $daysCount; $i++) {
                $date = $startDate->modify(sprintf('+%d days', $i));
                $days[] = new DateEntry($date, $today);
            }

            return $days;
        } catch (DateMalformedStringException $e) {
            throw new RuntimeException('Failed to get time period', previous: $e);
        }
    }

    /**
     * @param  DateEntry[]  $dayEntries
     * @return CalendarEvent[]
     */
    private function getEventsForDays(array $dayEntries): array
    {
        return [
            new CalendarEvent('Event 1', $dayEntries[0]->dateTime->setTime(23, 00), $dayEntries[1]->dateTime->setTime(3, 30)),
            // new CalendarEvent('Event 2', $dayEntries[0]->dateTime->setTime(11, 00), $dayEntries[0]->dateTime->setTime(11, 30)),
        ];
    }

    private function getViewType(Request $request): string
    {
        $viewType = $request->query('view', self::DEFAULT_VIEW_TYPE);

        return in_array($viewType, self::VIEW_TYPES, true) ? $viewType : self::DEFAULT_VIEW_TYPE;
    }
}
