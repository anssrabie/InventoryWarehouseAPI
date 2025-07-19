<?php

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
    )
    ->withMiddleware(function (Middleware $middleware): void {
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->renderable(function (Throwable $exception) {
            if (request()->expectsJson() || request()->is('api/*') || request()->wantsJson()) {

                $api = new class {
                    use ApiResponse;
                };

                $status = 500;
                $message = $exception->getMessage();

                if ($exception instanceof AuthenticationException) {
                    return $api->errorMessage('Unauthenticated.', 401);
                }

                if ($exception instanceof ValidationException) {
                    return $api->errorMessage($message);
                }

                if ($exception instanceof ModelNotFoundException) {
                    return $api->errorMessage('Resource not found.', 404);
                }

                if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                    return $api->errorMessage($message, $exception->getStatusCode());
                }

                return $api->errorMessage($message, $status);
            }
        });

    })->create();
