<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Sprout\Attributes\TenantRelation;
use Sprout\Database\Eloquent\Concerns\BelongsToTenant;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasUlids, Notifiable, BelongsToTenant, SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sistem_tenant_id',
        'email_verified_at',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
    ];

    #[TenantRelation]
    public function sistemTenant(): BelongsTo
    {
        return $this->belongsTo(
            related: SystemTenant::class,
            foreignKey: 'system_tenant_id',
        );
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
