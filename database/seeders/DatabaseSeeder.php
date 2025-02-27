<?php

namespace Database\Seeders;

use App\Models\SystemTenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $system_tenant = SystemTenant::factory()->create([
            'name' => 'Wesley',
            'description' => 'Teste de Tenant',
            'identifier' => 'wesley',
        ]);

        User::factory()->create([
            'name' => 'Wesley Cardoso',
            'email' => 'wesley@example.com',
            'system_tenant_id' => $system_tenant->id,
        ]);
    }
}
