<?php

namespace App\Observers;

use App\Models\AddressLog;
use App\Models\Card;
use App\Models\CardLog;
use App\Models\UserLog;
use Illuminate\Support\Facades\Request;

class CardObserver
{
    public function created(Card $card)
    {
        $this->logCardAction($card, 'created');
    }

    public function updated(Card $card)
    {
        $this->logCardAction($card, 'updated');
    }

    public function deleted(Card $card)
    {
        $this->logCardAction($card, 'deleted');
    }

    protected function logCardAction(Card $card, $action)
    {
        $ip = Request::ip();
        CardLog::create([
            ...$card->toArray(),
            'card_id' => $card->id,
            'address_log_id' => AddressLog::where('address_id', $card->address_id)->latest()->value('id'),
            'user_log_id' => UserLog::where('user_id', $card->user_id)->latest()->value('id'),
            'action' => $action,
            'ip_address' => $ip,
            'platform' => 'WEB'
        ]);
    }
}
