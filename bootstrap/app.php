<?php

use App\Http\Middleware\AlwaysAcceptJson;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
        then: function () {
            Route::prefix('api/v2')->group(function () {
                require __DIR__.'/../routes/api_v2.php';
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();  // se asegura de solicitar autenticación en cada petición
        $middleware->prependToGroup('api', AlwaysAcceptJson::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {

            if($request->wantsJson()){
                return response()->json(['message' => 'Object Not Found'], 404);
            }

        });
    })->create();
