<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AController;
use App\Models\Event;
use App\Permissions;
use App\Services\Router\Attributes\Get;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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

    /**
     * @throws InvalidArgumentException
     */
    #[Get('/api/event/history/{id}', 'event_history_get')]
    public function history(int $id): JsonResponse
    {
        if (! Gate::allows(Permissions::VIEW_EVENT)) {
            return new JsonResponse(null, JsonResponse::HTTP_FORBIDDEN);
        }

        $logs = DB::table('changelog')
            ->where('table_name', 'events')
            ->where('id_row', $id)
            ->orderBy('change_order')
            ->get();

        $users = DB::table('users')->pluck('full_name', 'id');

        $columnMap = [
            'title' => 'Title',
            'description' => 'Description',
            'event_type_id' => 'Event Type',
            'assigned_user_id' => 'Assigned User',
            'start_date_time' => 'Event start',
            'end_date_time' => 'Event end',
            'created_by_user_id' => 'Created By',
        ];

        $history = $logs->map(function ($log) use ($users, $columnMap) {
            $columnName = $log->column_name ? ($columnMap[$log->column_name] ?? $log->column_name) : '';

            $oldValue = $log->old_value ?? '';
            $newValue = $log->new_value ?? '';

            if (in_array($log->column_name, ['assigned_user_id', 'created_by_user_id'])) {
                $oldValue = $oldValue ? ($users[$oldValue] ?? $oldValue) : '';
                $newValue = $newValue ? ($users[$newValue] ?? $newValue) : '';
            }

            $userFullName = $log->id_changed_by ? ($users[$log->id_changed_by] ?? 'System') : 'System';

            return [
                'order' => $log->change_order,
                'action' => $log->action ?? 'update',
                'column_name' => $columnName,
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'changed_at' => $log->changed_at ?? '',
                'id_changed_by' => $userFullName,
            ];
        });

        return new JsonResponse($history);
    }
}
