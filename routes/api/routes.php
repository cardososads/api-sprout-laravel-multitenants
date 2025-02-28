<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::tenanted(static function (Router $router) {

    $router->middleware(['identifier'])->as('auth:')->prefix('auth')->group(base_path(
        path: 'routes/api/auth.php'
    ));

    $router->middleware(['auth:sanctum'])->group(static function () use ($router):void {
        $router->as('users:')->prefix('users')->group(base_path(
            path: 'routes/api/users.php',
        ));
    });

});
