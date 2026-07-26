<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            // Product family: game_key, gift_card, subscription, prepaid, software
            $table->string('type')->default('game_key');
            // How stock/keys are fulfilled: manual (uploaded keys) or api (bought from supplier on demand)
            $table->string('fulfillment')->default('manual');
            $table->decimal('base_price', 18, 2)->default(0);   // sell price in base currency
            $table->decimal('cost_price', 18, 2)->default(0);   // supplier cost, for margin calc
            $table->integer('stock')->default(0);               // manual stock counter (api = virtually unlimited)
            $table->string('status')->default('draft');         // draft, active, out_of_stock, archived
            $table->boolean('is_featured')->default(false);
            $table->string('supplier_product_id')->nullable();  // id on the supplier side
            $table->json('meta')->nullable();                   // platform, region, extra attributes
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id');
            $table->index('supplier_id');
            $table->index('status');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
