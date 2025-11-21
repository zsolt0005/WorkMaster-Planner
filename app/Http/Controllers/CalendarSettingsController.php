<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Permissions;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Throwable;

final class CalendarSettingsController extends AController
{
    #[Get('/calendar-settings', 'calendar_settings')]
    public function default(): View
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        return view('calendar-settings.event_types', [
            'eventTypes' => EventType::all(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    #[Post('/calendar-settings/event-type/create', 'calendar_settings__event_type__create')]
    public function createEventType(Request $request): RedirectResponse
    {
        $data = $request->validate($this->getEventTypeValidations());

        try {
            EventType::create($data);
            $this->flashSuccess(__('calendar_settings.create.success'));
        } catch (Exception $e) {
            $this->flashError(__('calendar_settings.create.error'));
        }

        return redirect()->route('calendar_settings');
    }

    /**
     * @throws ValidationException
     */
    #[Post('/calendar-settings/event-type/update{eventType}', 'calendar_settings__event_type__update')]
    public function updateEventType(Request $request, EventType $eventType): RedirectResponse
    {
        $data = $request->validate($this->getEventTypeValidations(true));

        try {
            $eventType->updateOrFail($data);
            $this->flashSuccess(__('calendar_settings.update.success', ['id' => $eventType->identifier]));
        } catch (Throwable $e) {
            $this->flashError(__('calendar_settings.update.error', ['id' => $eventType->identifier]));
        }

        return redirect()->route('calendar_settings');
    }

    #[Post('/calendar-settings/event-type/delete/{eventType}', 'calendar_settings__event_type__delete')]
    public function deleteEventType(EventType $eventType): RedirectResponse
    {
        try {
            $eventType->deleteOrFail();
            $this->flashSuccess(__('calendar_settings.delete.success', ['id' => $eventType->identifier]));
        } catch (Throwable $e) {
            $this->flashError(__('calendar_settings.delete.error', ['id' => $eventType->identifier]));
        }

        return redirect()->route('calendar_settings');
    }

    private function getEventTypeValidations(bool $isUpdate = false): array
    {
        $rules = [
            'identifier' => ['required', 'string', 'max:255', 'unique:event_types,identifier'],
            'description' => ['nullable', 'string', 'max:255'],
            'background_color' => ['string', 'max:7'],
            'text_color' => ['string', 'max:7'],
        ];

        if ($isUpdate) {
            unset($rules['identifier']);
        }

        return $rules;
    }
}
