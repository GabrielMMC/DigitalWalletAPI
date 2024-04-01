<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalLog extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'withdrawal_logs';

    protected $fillable = [
        'amount',
        'action',
        'platform',
        'ip_address',
        'bank_account_log_id',
        'user_log_id',
        'withdrawal_id',
    ];
}
