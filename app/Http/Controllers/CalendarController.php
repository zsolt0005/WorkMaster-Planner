<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\CalendarEvent;
use App\Dto\DateEntry;
use App\Models\Event;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Carbon\Carbon;
use DateMalformedStringException;
use DateTimeImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Arrays;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use RuntimeException;
use Symfony\Component\VarDumper\VarDumper;
use Throwable;

final class CalendarController extends AController
{
    private const array VIEW_TYPES = ['month', 'week', 'day'];

    private const string DEFAULT_VIEW_TYPE = 'week';

    public function __construct(public readonly Logger $logger)
    {
    }

    #[Get('/', 'calendar')]
    public function default(Request $request): View
    {
        $viewType = $this->getViewType($request);

        $dayEntries = $this->getCalendarDayEntries($viewType);
        $events = $this->getEventsForDays($dayEntries);

        return view('calendar.calendar', [
            'viewType' => $viewType,
            'dayEntries' => $dayEntries,
            'events' => $events,
        ]);
    }

    /**
     * @throws JsonException
     */
    #[Post('/calendar/event/create', 'calendar__event__create')]
    public function createEvent(Request $request): RedirectResponse
    {
        $data = $request->all();

        $data['create_event__event_type_id'] = Json::decode($data['create_event__event_type_id'] ?? '{}', true)[0]['value'] ?? null;
        $data['create_event__assigned_user_id'] = Json::decode($data['create_event__assigned_user_id'] ?? '{}', true)[0]['id'] ?? null;

        $validator = Validator::make($data, [
            'create_event__title' => [
                'required',
                'string',
                'min:1',
                'max:255',
            ],
            'create_event__description' => [
                'nullable',
                'string',
                'max:255',
            ],
            'create_event__start_date_time' => [
                'required',
                'date',
            ],
            'create_event__end_date_time' => [
                'required',
                'date',
                function (string $attribute, mixed $value, \Closure $fail) use ($data): void {
                    // Only validate if start and end are valid dates
                    try {
                        $start = Carbon::parse($data['create_event__start_date_time'] ?? null);
                        $end = Carbon::parse($value);
                    } catch (\Throwable) {
                        return; // date rule will handle invalid formats
                    }

                    if ($end->lessThan($start->copy()->addMinute())) {
                        $fail('The end date and time must be at least 1 minute after the start date and time.');
                    }
                },
            ],
            'create_event__event_type_id' => [
                'required',
                'string',
                'exists:event_types,identifier',
            ],
            'create_event__assigned_user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ]);

        if ($validator->fails()) {
            $this->flashError($validator->errors()->first());

            return redirect()->route('calendar');
        }

        // Fix keys
        foreach ($data as $key => $value) {
            $newKey = str_replace('create_event__', '', $key);
            $data[$newKey] = $value;
            unset($data[$key]);
        }

        $data['created_by_user_id'] = $this->getAuthUser()->id;

        try {
            Event::create($data);
            $this->flashSuccess(__('calendar.create_event.success'));
        } catch (Throwable $e) {
            $this->flashError(__('calendar.create_event.failed'));
            $this->logger->error($e);
        }

        return redirect()->route('calendar');
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
     * @param  non-empty-array<DateEntry>  $dayEntries
     * @return CalendarEvent[]
     */
    private function getEventsForDays(array $dayEntries): array
    {
        $firstDay = Arrays::first($dayEntries)->dateTime;
        $lastDay = Arrays::last($dayEntries)->dateTime;

        $eventsData = [];

        try {
            $events = Event::getBetweenDates($firstDay, $lastDay);

            foreach ($events as $event) {
                $eventsData[] = new CalendarEvent($event);
            }
        } catch (Throwable $e) {
            return []; // Should never happen, but just in case
        }

        return $eventsData;
    }

    private function getViewType(Request $request): string
    {
        $viewType = $request->query('view', self::DEFAULT_VIEW_TYPE);

        return in_array($viewType, self::VIEW_TYPES, true) ? $viewType : self::DEFAULT_VIEW_TYPE;
    }
}
