<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\SystemTenantFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sprout\Contracts\Tenant;
use Sprout\Contracts\TenantHasResources;
use Sprout\Database\Eloquent\Concerns\HasTenantResources;
use Sprout\Database\Eloquent\Concerns\IsTenant;

/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $identifier
 * @property string $resource_key
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 *
 */
class SystemTenant extends Model implements Tenant, TenantHasResources
{
    /** @use HasFactory<SystemTenantFactory> */
    use HasFactory, HasTenantResources, HasUlids, IsTenant;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'description',
        'identifier',
        'resource_key',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(
            related: User::class,
            foreignKey: 'user_id',
        );
    }
}
