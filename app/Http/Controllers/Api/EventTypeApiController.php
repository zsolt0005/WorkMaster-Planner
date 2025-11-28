<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AController;
use App\Models\EventType;
use App\Services\Router\Attributes\Get;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

final class EventTypeApiController extends AController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Get('/api/event-types/search', 'event_types_search')]
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q');

        $eventTypes = EventType::query()
            ->where(EventType::IDENTIFIER, 'like', "%{$q}%")
            ->get();

        $output = $eventTypes->map(static fn (EventType $eventType) => ['value' => $eventType->identifier]);

        return new JsonResponse($output);
    }
}
