<?php

namespace App\Http\Resources;

use App\Models\SystemTenant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property SystemTenant $resource */
final class SystemTenantResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'identifier' => $this->resource->identifier,
            'created' => new DateResource(
                resource: $this->resource->created_at,
            ),
        ];
    }
}
