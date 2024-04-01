<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'cards';

    protected $fillable = [
        'holder_document',
        'holder_name',
        'last_four_digits',
        'brand',
        'expiration',
        'card_code',
        'user_id',
        'address_id',
    ];
}
