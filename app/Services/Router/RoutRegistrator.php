<?php declare(strict_types=1);

namespace App\Services\Router;

use App\Services\Router\Attributes\ARequest;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Middleware;
use App\Services\Router\Attributes\Post;
use App\Services\Router\Data\RouteData;
use Illuminate\Support\Facades\Route;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

/**
 * @template T of object
 */
class RoutRegistrator
{
    private ?string $defaultMiddleware = null;

    /** @var class-string<T>|null */
    private ?string $controllerBase = null;

    private ?string $controllersPath = null;

    public static function setup(): self
    {
        return new self();
    }

    public function defaultMiddleware(string $defaultMiddleware): self
    {
        $this->defaultMiddleware = $defaultMiddleware;

        return $this;
    }

    /**
     * @param  class-string<T>  $class
     */
    public function controllerBase(string $class): self
    {
        $this->controllerBase = $class;

        return $this;
    }

    public function controllersPath(string $path): self
    {
        $this->controllersPath = $path;

        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function register(): void
    {
        if ($this->controllerBase === null || $this->controllersPath === null) {
            return;
        }

        $controllers = $this->getControllers();
        $routesData = $this->prepareRoutesData($controllers);

        foreach ($routesData as $middleware => $routes) {
            if ($middleware === '') {
                $this->registerRoutes($routes);

                continue;
            }

            $this->registerRoutesWithMiddleware($middleware, $routes);
        }
    }

    /**
     * @return class-string<T>[]
     */
    private function getControllers(): array
    {
        $this->autoLoadControllers();

        return array_values(
            array_filter(
                get_declared_classes(),
                fn (string $class): bool => is_subclass_of($class, $this->controllerBase)
            )
        );
    }

    /**
     * @throws DirectoryNotFoundException
     */
    private function autoLoadControllers(): void
    {
        $basePath = base_path($this->controllersPath);

        $finder = new Finder();
        $finder->files()->in($basePath)->name('*.php');

        $controllers = [];
        foreach ($finder as $file) {
            require_once $file->getRealPath();
        }
    }

    /**
     * @param  class-string<T>[]  $controllers
     * @return array<string, RouteData[]>
     *
     * @throws ReflectionException
     */
    private function prepareRoutesData(array $controllers): array
    {
        $routesData = [];

        foreach ($controllers as $controller) {
            $reflectionClass = new ReflectionClass($controller);

            $publicMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
            foreach ($publicMethods as $method) {
                $attributes = array_filter(
                    $method->getAttributes(),
                    static fn (ReflectionAttribute $attribute): bool => in_array($attribute->getName(), [Get::class, Post::class], true)
                );

                if (empty($attributes)) {
                    continue;
                }

                $middleware = ($method->getAttributes(Middleware::class)[0] ?? null)?->newInstance()->name
                    ?? ($this->defaultMiddleware ?? '');

                foreach ($attributes as $attribute) {
                    /** @var ARequest $attributeInstance */
                    $attributeInstance = $attribute->newInstance();

                    $routesData[$middleware][] = new RouteData(
                        $reflectionClass->getName(),
                        $method->getName(),
                        $attributeInstance->method,
                        $attributeInstance->path,
                        $attributeInstance->name,
                    );
                }
            }
        }

        return $routesData;
    }

    /**
     * @param  RouteData[]  $routes
     */
    private function registerRoutesWithMiddleware(string $middleware, array $routes): void
    {
        Route::middleware($middleware)->group(static function () use ($routes) {
            foreach ($routes as $route) {
                Route::{$route->requestMethod}($route->path, [$route->class, $route->method])->name($route->name);
            }
        });
    }

    /**
     * @param  RouteData[]  $routes
     */
    private function registerRoutes(array $routes): void
    {
        foreach ($routes as $route) {
            Route::{$route->requestMethod}($route->path, [$route->class, $route->method])->name($route->name);
        }
    }
}
