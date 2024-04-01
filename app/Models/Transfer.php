<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $keyType = 'string';
    protected $table = 'transfers';

    protected $fillable = [
        'amount',
        'user_sender_id',
        'user_receiver_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_receiver_id', 'id');
    }
}
