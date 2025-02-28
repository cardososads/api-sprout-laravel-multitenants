<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sprout\Attributes\TenantRelation;
use Sprout\Database\Eloquent\Concerns\BelongsToTenant;

abstract class AbstractSystemTenant extends Model
{
    use BelongsToTenant;
    #[TenantRelation]
    public function system_tenant(): BelongsTo
    {
        return $this->belongsTo(
            related: SystemTenant::class,
            foreignKey: 'system_tenant_id',
        );
    }
}
