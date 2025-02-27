<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SystemTenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemTenant> */
final class SystemTenantFactory extends Factory
{
    /** @var class-string<SystemTenant> */
    protected $model = SystemTenant::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'description' => $this->faker->realText(),
            'identifier' => $this->faker->unique()->userName(),
            'resource_key' => $this->faker->uuid(),
        ];
    }
}
