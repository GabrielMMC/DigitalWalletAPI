<?php

namespace App\Observers;

use App\Models\Address;
use App\Models\AddressLog;
use App\Models\UserLog;
use Illuminate\Support\Facades\Request;

class AddressObserver
{
    public function created(Address $address)
    {
        $this->logAddressAction($address, 'created');
    }

    public function updated(Address $address)
    {
        $this->logAddressAction($address, 'updated');
    }

    public function deleted(Address $address)
    {
        $this->logAddressAction($address, 'deleted');
    }

    protected function logAddressAction(Address $address, $action)
    {
        $ip = Request::ip();
        AddressLog::create([
            ...$address->toArray(),
            'address_id' => $address->id,
            'user_log_id' => UserLog::where('user_id', $address->user_id)->latest()->value('id'),
            'action' => $action,
            'ip_address' => $ip,
            'platform' => 'WEB'
        ]);
    }
}
