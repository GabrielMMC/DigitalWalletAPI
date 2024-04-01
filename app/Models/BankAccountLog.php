<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccountLog extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'bank_account_logs';

    protected $fillable = [
        'bank',
        'branch_number',
        'branch_digit',
        'account_number',
        'account_digit',
        'action',
        'platform',
        'ip_address',
        'bank_account_id',
        'user_log_id',
    ];
}
