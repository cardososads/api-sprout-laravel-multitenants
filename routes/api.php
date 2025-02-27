<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::tenanted(static function (Router $router) {

    $router->middleware(['identifier'])->as('auth:')->prefix('auth')->group(static function () use ($router) {
        $router->post('login', LoginController::class)->middleware(['identifier']);
    });

    $router->middleware('auth:sanctum')->group(static function () use ($router) {
        $router->get('/users', fn () => response()->json([User::all()]));

    });
});
