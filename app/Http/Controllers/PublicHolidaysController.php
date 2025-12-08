<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use App\Permissions;
use App\Services\PublicHolidayService;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

final class PublicHolidaysController extends AController
{
    #[Get('/calendar-settings/public-holidays', 'public_holidays')]
    public function default(): View
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        return view('calendar-settings.public_holidays');
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     * @throws ValidationException
     */
    #[Post('/calendar-settings/public-holidays/sync', 'public_holidays__sync')]
    public function sync(Request $request, PublicHolidayService $holidayService): RedirectResponse
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        $validated = $request->validate([
            'country' => ['required', 'in:SK,CZ'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $country = $validated['country'];
        $year = (int) $validated['year'];

        $from = sprintf('%d-01-01', $year);
        $to = sprintf('%d-12-31', $year);
        $lang = 'EN';

        $created = $holidayService->syncPublicHolidaysToEvents(
            countryIsoCode: $country,
            validFrom: $from,
            validTo: $to,
            languageIsoCode: $lang,
            subdivisionCode: null,
            holidayEventTypeId: 'holiday',
            userId: $this->getAuthUser()->id,
        );

        if ($created === 0) {
            $this->flashInfo(__('No new public holidays were created (they may already exist).'));
        } else {
            $this->flashSuccess(__('Created :count public holiday events.', ['count' => $created]));
        }

        return redirect()->route('public_holidays');
    }

    #[Post('/calendar-settings/public-holidays/clear', 'public_holidays__clear')]
    public function clear(): RedirectResponse
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        $deleted = Event::query()
            ->where(Event::EVENT_TYPE_ID, 'holiday')
            ->delete();

        if ($deleted === 0) {
            $this->flashInfo(__('No public holiday events found to delete.'));
        } else {
            $this->flashSuccess(__('Deleted :count public holiday events.', ['count' => $deleted]));
        }

        return redirect()->route('public_holidays');
    }
}
