<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('calendar'));
        }

        if (! $user->is_admin) {
            abort(404, 'PAGE_NOT_FOUND');
        }

        return $next($request);
    }
}
