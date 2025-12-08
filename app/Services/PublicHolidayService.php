<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class PublicHolidayService
{
    private string $baseUrl = 'https://openholidaysapi.org';

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function syncPublicHolidaysToEvents(
        string $countryIsoCode,
        string $validFrom,
        string $validTo,
        string $languageIsoCode,
        ?string $subdivisionCode,
        string $holidayEventTypeId,
        int $userId,
    ): int {
        $startDateTime = $validFrom.' 00:00:00';
        $endDateTime = $validTo.' 23:59:59';

        $alreadyExists = Event::query()
            ->where(Event::EVENT_TYPE_ID, $holidayEventTypeId)
            ->whereBetween(Event::START_DATE_TIME, [$startDateTime, $endDateTime])
            ->exists();

        if ($alreadyExists) {
            Log::info('Holiday events already exist, skipping API call', [
                'country' => $countryIsoCode,
                'from' => $validFrom,
                'to' => $validTo,
                'lang' => $languageIsoCode,
            ]);

            return 0;
        }

        $holidays = $this->getPublicHolidays(
            countryIsoCode: $countryIsoCode,
            validFrom: $validFrom,
            validTo: $validTo,
            languageIsoCode: $languageIsoCode,
            subdivisionCode: $subdivisionCode,
        );

        $created = 0;

        foreach ($holidays as $holiday) {
            $startDate = $holiday['startDate'] ?? null;
            $endDate = $holiday['endDate'] ?? $startDate;

            if (! $startDate) {
                continue;
            }

            $name = null;
            if (! empty($holiday['name']) && is_array($holiday['name'])) {
                foreach ($holiday['name'] as $nameItem) {
                    if (($nameItem['language'] ?? null) === $languageIsoCode) {
                        $name = $nameItem['text'] ?? null;
                        break;
                    }
                }
                $name ??= $holiday['name'][0]['text'] ?? null;
            }
            $name ??= 'Public holiday';

            $startDateTime = $startDate.' 00:00:00';
            $endDateTime = $endDate.' 23:59:59';

            $exists = Event::query()
                ->where(Event::EVENT_TYPE_ID, $holidayEventTypeId)
                ->whereDate(Event::START_DATE_TIME, $startDate)
                ->where('title', $name)
                ->exists();

            if ($exists) {
                continue;
            }

            Event::create([
                'event_type_id' => $holidayEventTypeId,
                'assigned_user_id' => $userId,
                'created_by_user_id' => $userId,
                'title' => $name,
                'description' => 'Public holiday in '.$countryIsoCode,
                'start_date_time' => $startDateTime,
                'end_date_time' => $endDateTime,
            ]);

            $created++;
        }

        Log::info('Holiday events synced from API', [
            'country' => $countryIsoCode,
            'from' => $validFrom,
            'to' => $validTo,
            'lang' => $languageIsoCode,
            'created' => $created,
        ]);

        return $created;
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getPublicHolidays(
        string $countryIsoCode,
        string $validFrom,
        string $validTo,
        string $languageIsoCode = 'EN',
        ?string $subdivisionCode = null,
        int $pageSize = 50,
        int $pageNumber = 1,
    ): array {
        $query = [
            'countryIsoCode' => $countryIsoCode,
            'languageIsoCode' => $languageIsoCode,
            'validFrom' => $validFrom,
            'validTo' => $validTo,
            'pageSize' => $pageSize,
            'pageNumber' => $pageNumber,
        ];

        if ($subdivisionCode) {
            $query['subdivisionCode'] = $subdivisionCode;
        }

        $response = Http::acceptJson()
            ->baseUrl($this->baseUrl)
            ->get('/PublicHolidays', $query);

        $response->throw();

        return $response->json();
    }
}
