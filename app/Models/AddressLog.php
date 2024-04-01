<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressLog extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'address_logs';

    protected $fillable = [
        'zip_code',
        'state',
        'city',
        'nbhd',
        'street',
        'complement',
        'number',
        'action',
        'platform',
        'ip_address',
        'user_log_id',
        'address_id',
    ];
}
