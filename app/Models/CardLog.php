<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardLog extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'card_logs';

    protected $fillable = [
        'holder_document',
        'holder_name',
        'last_four_digits',
        'brand',
        'expiration',
        'card_code',
        'action',
        'platform',
        'ip_address',
        'user_log_id',
        'address_log_id',
        'card_id',
    ];
}
