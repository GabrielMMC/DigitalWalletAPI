<?php

namespace App\Observers;

use App\Models\CardLog;
use App\Models\Recharge;
use App\Models\RechargeLog;
use App\Models\UserLog;
use Illuminate\Support\Facades\Request;

class RechargeObserver
{
    public function created(Recharge $recharge)
    {
        $this->logAddressAction($recharge, 'created');
    }

    public function updated(Recharge $recharge)
    {
        $this->logAddressAction($recharge, 'updated');
    }

    public function deleted(Recharge $recharge)
    {
        $this->logAddressAction($recharge, 'deleted');
    }

    protected function logAddressAction(Recharge $recharge, $action)
    {
        $ip = Request::ip();
        RechargeLog::create([
            ...$recharge->toArray(),
            'recharge_id' => $recharge->id,
            'card_log_id' => CardLog::where('card_id', $recharge->card_id)->latest()->value('id'),
            'user_log_id' => UserLog::where('user_id', $recharge->user_id)->latest()->value('id'),
            'action' => $action,
            'ip_address' => $ip,
            'platform' => 'WEB'
        ]);
    }
}
