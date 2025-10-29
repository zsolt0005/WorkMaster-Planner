<?php declare(strict_types=1);

use App\Http\Controllers\AController;
use App\Services\Router\RoutRegistrator;

try {
    RoutRegistrator::setup()
        ->controllerBase(AController::class)
        ->controllersPath('app/Http/Controllers')
        ->defaultMiddleware('auth')
        ->register();
} catch (Exception $e) {
    dd($e);
}
