<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Support\ApiResponse;
use App\Exceptions\TicketAlreadyEscalatedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (
            NotFoundHttpException $e,
            Request $request
        ) {
            if ($request->is('api/*')) {
                return ApiResponse::error(
                    'Ticket not found.',
                    Response::HTTP_NOT_FOUND
                );
            }
        });

        $exceptions->render(function (
            TicketAlreadyEscalatedException $e,
            Request $request
        ) {

            if ($request->is('api/*')) {

                return ApiResponse::error(
                    $e->getMessage(),
                    Response::HTTP_CONFLICT
                );
            }
        });

        $exceptions->render(function (
            Throwable $e,
            Request $request
        ) {

            if ($request->is('api/*')) {

                return ApiResponse::error(
                    config('app.debug')
                        ? $e->getMessage()
                        : 'Something went wrong.',
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        });
    })->create();
