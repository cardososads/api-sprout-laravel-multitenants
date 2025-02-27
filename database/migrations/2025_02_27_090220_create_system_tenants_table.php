<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_tenants', static function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('name');
            $table->string('description')->nullable();

            $table->string('identifier');
            $table->string('resource_key');

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignUlid('system_tenant_id')->index()->constrained('system_tenants')->cascadeOnDelete();
            $table->dropUnique('users_email_unique'); // Se existir
            $table->unique(['email', 'system_tenant_id'], 'email_tenant_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sytem_tenants');
    }
};
