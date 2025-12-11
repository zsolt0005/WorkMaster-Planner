<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AController;
use App\Models\Event;
use App\Permissions;
use App\Services\Router\Attributes\Get;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;

final class EventApiController extends AController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Get('/api/event/details/{id}', 'event_details_get')]
    public function get(int $id): JsonResponse
    {
        if (! Gate::has(Permissions::VIEW_EVENT)) {
            $this->flashError('You do not have permission to retrieve event details.');

            return new JsonResponse(null, JsonResponse::HTTP_FORBIDDEN);
        }

        $event = Event::query()
            ->with(['eventType', 'assignedUser', 'createdByUser'])
            ->findOrFail($id);

        return new JsonResponse([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'start_date_time' => $event->start_date_time,
            'end_date_time' => $event->end_date_time,
            'event_type' => $event->eventType ?? $event->event_type_id,
            'assigned_user' => $event->assignedUser ?? $event->assigned_user_id,
            'created_by_user' => $event->createdByUser ?? $event->created_by_user_id,
        ]);
    }
}
