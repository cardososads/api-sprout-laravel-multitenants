<?php

declare(strict_types=1);

use App\Http\Resources\UserResource;
use App\Http\Responses\PaginateCollectionResponse;
use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::tenanted(static function (Router $router): void {
    $router->get('/', fn () => new PaginateCollectionResponse(
        data: UserResource::collection(
            resource: User::query()->simplePaginate(),
        ),
    ));
});


