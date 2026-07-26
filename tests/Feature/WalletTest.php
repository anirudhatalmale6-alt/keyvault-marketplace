<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    public function test_credit_and_debit_update_balance_and_record_transactions(): void
    {
        $user = User::factory()->create();
        $wallet = $user->ensureWallet();

        $wallet->credit(100, 'topup', 'Initial top-up');
        $this->assertEquals(100, $wallet->fresh()->balance);

        $wallet->debit(30, 'order-1', 'Purchase');
        $this->assertEquals(70, $wallet->fresh()->balance);

        $this->assertCount(2, $wallet->transactions);
    }

    public function test_debit_fails_when_balance_is_insufficient(): void
    {
        $user = User::factory()->create();
        $wallet = $user->ensureWallet();
        $wallet->credit(10);

        $this->expectException(\RuntimeException::class);
        $wallet->debit(50);
    }

    public function test_each_user_gets_a_unique_referral_code(): void
    {
        $a = User::factory()->create();
        $b = User::factory()->create();

        $this->assertNotEmpty($a->referral_code);
        $this->assertNotEquals($a->referral_code, $b->referral_code);
    }
}
