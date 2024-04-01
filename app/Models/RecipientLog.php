<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipientLog extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'recipient_logs';

    protected $fillable = [
        'recipient_code',
        'balance',
        'document',
        'type',
        'user_log_id',
        'action',
        'platform',
        'ip_address',
        'recipient_id',
    ];
}
