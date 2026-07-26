<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('email'); // customer, admin
            $table->string('locale', 5)->default('en')->after('role');   // en, fr, ar
            $table->string('currency', 3)->default('USD')->after('locale');
            $table->string('referral_code')->nullable()->unique()->after('currency');
            $table->foreignId('referred_by')->nullable()->after('referral_code')
                  ->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('referred_by');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referred_by');
            $table->dropColumn(['role', 'locale', 'currency', 'referral_code', 'is_active']);
        });
    }
};
