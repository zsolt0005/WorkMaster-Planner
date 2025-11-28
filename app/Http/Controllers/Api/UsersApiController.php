<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AController;
use App\Models\User;
use App\Services\Router\Attributes\Get;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

final class UsersApiController extends AController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Get('/api/users/search', 'users_search')]
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q');

        $users = User::query()
            ->where(User::USERNAME, 'like', "%{$q}%")
            ->orWhere(User::FULL_NAME, 'like', "%{$q}%")
            ->get();

        $output = $users->map(static fn (User $user) => ['value' => $user->full_name, 'id' => $user->id]);

        return new JsonResponse($output);
    }
}
