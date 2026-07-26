<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance', 'currency'];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Atomically credit the wallet and record the transaction.
     * Row-locked to stay correct under concurrent requests/jobs.
     */
    public function credit(float $amount, ?string $reference = null, ?string $description = null): WalletTransaction
    {
        return $this->applyTransaction('credit', $amount, $reference, $description);
    }

    /**
     * Atomically debit the wallet. Throws when funds are insufficient.
     */
    public function debit(float $amount, ?string $reference = null, ?string $description = null): WalletTransaction
    {
        return $this->applyTransaction('debit', $amount, $reference, $description);
    }

    protected function applyTransaction(string $type, float $amount, ?string $reference, ?string $description): WalletTransaction
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive.');
        }

        return DB::transaction(function () use ($type, $amount, $reference, $description) {
            /** @var Wallet $wallet */
            $wallet = static::whereKey($this->getKey())->lockForUpdate()->first();

            if ($type === 'debit' && (float) $wallet->balance < $amount) {
                throw new \RuntimeException('Insufficient wallet balance.');
            }

            $wallet->balance = $type === 'credit'
                ? (float) $wallet->balance + $amount
                : (float) $wallet->balance - $amount;
            $wallet->save();

            $tx = $wallet->transactions()->create([
                'type'          => $type,
                'amount'        => $amount,
                'balance_after' => $wallet->balance,
                'reference'     => $reference,
                'description'   => $description,
            ]);

            $this->balance = $wallet->balance;

            return $tx;
        });
    }
}
