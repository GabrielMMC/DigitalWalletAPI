<?php

namespace App\Models;

use App\Services\PaymentService;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'recipients';

    protected $fillable = [
        'recipient_code',
        'balance',
        'document',
        'type',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class, 'recipient_id', 'id');
    }

    public function scopeRemoveFromBalance($query, $userId, $amount)
    {
        $recipient = $query->firstWhere('user_id', $userId);

        if ($recipient) {
            $recipient->balance -= $amount;
            $recipient->save();
        }
    }

    public function scopeAddFromBalance($query, $userId, $amount)
    {
        $recipient = $query->firstWhere('user_id', $userId);

        if ($recipient) {
            $recipient->balance += $amount;
            $recipient->save();
        }
    }
}
