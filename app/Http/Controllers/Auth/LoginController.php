<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\TokenResponse;
use App\Models\SystemTenant;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\DatabaseManager;
use Laravel\Sanctum\NewAccessToken;
use Sprout\Attributes\CurrentTenant;
use Throwable;

final readonly class LoginController
{
    public function __construct(
        #[CurrentTenant]
        private SystemTenant $systemTenant,
        private DatabaseManager $database,
    ){}

    /**
     * @throws ValidationException | Throwable
     */
    public function __invoke(LoginRequest $request): TokenResponse
    {
        $request->authenticate(
            systemTenantID: $this->systemTenant->id,
        );

        /** @var NewAccessToken $token */

        $token = $this->database->transaction(
            callback: fn () => $request->user()?->createToken(
                name: $request->header('X-Integration-Name'),
                abilities: [$this->systemTenant->identifier . ':*'],
            ),
            attempts: 3
        );

        return new TokenResponse(
            token: $token->plainTextToken,
        );
    }
}
