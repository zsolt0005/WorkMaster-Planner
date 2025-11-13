<?php declare(strict_types=1);

namespace App\Http\Controllers;

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

        try {
            return view('calendar', [
                'timePeriod' => $this->getTimePeriod(),
            ]);
        } catch (DateMalformedStringException $e) {
            throw new RuntimeException('Failed to get time period', previous: $e);
        }
    }

    /**
     * @throws DateMalformedStringException
     */
    private function getTimePeriod(): array
    {
        $today = new DateTimeImmutable('today');

        // ISO-8601: N = 1 (Mon) .. 7 (Sun)
        $isoDay = (int) $today->format('N');
        $monday = $today->modify(sprintf('-%d day', $isoDay - 1));

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $monday->modify(sprintf('+%d days', $i));
            $days[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('l'),
                'month' => $date->format('M'),
                'day' => $date->format('j'),
                'isWeekend' => $date->format('N') >= 6,
                'isToday' => $date->format('Y-m-d') === $today->format('Y-m-d'),
            ];
        }

        return $days;
    }
}
