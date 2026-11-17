<?php

use App\Http\Middleware\AuthenticatedMiddleware;
use App\Http\Middleware\AuthenticateLogin;
use App\Http\Middleware\HttpSecure;
use App\Http\Middleware\RTAuth;
use App\Http\Middleware\RWAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend(HttpSecure::class);

        $middleware->validateCsrfTokens(except: [
            'api/data/get-nik',
            'kritik-saran/process',
        ]);

        $middleware->alias([
            'auth.rt'       => RTAuth::class,
            'auth.rw'       => RWAuth::class,
            'auth.loggedin' => AuthenticatedMiddleware::class,
            'auth.login'    => AuthenticateLogin::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
