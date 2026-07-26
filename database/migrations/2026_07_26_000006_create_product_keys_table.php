<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The actual deliverable digital goods (game keys, gift-card codes, etc.).
        // The `code` column is encrypted at the application layer before storage.
        Schema::create('product_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('order_item_id')->nullable()->constrained('order_items')->nullOnDelete();
            $table->text('code');                          // encrypted
            $table->string('status')->default('available'); // available, reserved, sold
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->index('product_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_keys');
    }
};
