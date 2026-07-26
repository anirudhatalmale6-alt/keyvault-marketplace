<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('driver')->default('manual'); // maps to a SupplierDriver class (g2a, kinguin, ...)
            $table->string('api_endpoint')->nullable();
            $table->text('credentials')->nullable();      // encrypted JSON (api keys / secrets)
            $table->boolean('is_active')->default(true);
            $table->boolean('auto_sync')->default(false);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
