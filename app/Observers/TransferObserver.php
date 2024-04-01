<?php

namespace App\Observers;

use App\Models\TransferLog;
use App\Models\Transfer;
use App\Models\UserLog;
use Illuminate\Support\Facades\Request;

class TransferObserver
{
    public function created(Transfer $transfer)
    {
        $this->logTransferAction($transfer, 'created');
    }

    public function updated(Transfer $transfer)
    {
        $this->logTransferAction($transfer, 'updated');
    }

    public function deleted(Transfer $transfer)
    {
        $this->logTransferAction($transfer, 'deleted');
    }

    protected function logTransferAction(Transfer $transfer, $action)
    {
        $ip = Request::ip();
        TransferLog::create([
            ...$transfer->toArray(),
            'transfer_id' => $transfer->id,
            'user_receiver_log_id' => UserLog::where('user_id', $transfer->user_receiver_id)->latest()->value('id'),
            'user_sender_log_id' => UserLog::where('user_id', $transfer->user_sender_id)->latest()->value('id'),
            'action' => $action,
            'ip_address' => $ip,
            'platform' => 'WEB'
        ]);
    }
}
