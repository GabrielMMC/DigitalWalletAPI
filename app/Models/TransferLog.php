<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferLog extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'transfer_logs';

    protected $fillable = [
        'amount',
        'action',
        'platform',
        'ip_address',
        'user_sender_log_id',
        'user_receiver_log_id',
        'transfer_id',
    ];
}
