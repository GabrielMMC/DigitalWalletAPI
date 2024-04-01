<?php

namespace App\Observers;

use App\Models\Recipient;
use App\Models\RecipientLog;
use App\Models\UserLog;
use Illuminate\Support\Facades\Request;

class RecipientObserver
{
    public function created(Recipient $recipient)
    {
        $this->logRecipientAction($recipient, 'created');
    }

    public function updated(Recipient $recipient)
    {
        $this->logRecipientAction($recipient, 'updated');
    }

    public function deleted(Recipient $recipient)
    {
        $this->logRecipientAction($recipient, 'deleted');
    }

    protected function logRecipientAction(Recipient $recipient, $action)
    {
        $ip = Request::ip();
        RecipientLog::create([
            ...$recipient->toArray(),
            'recipient_id' => $recipient->id,
            'user_log_id' => UserLog::where('user_id', $recipient->user_id)->latest()->value('id'),
            'action' => $action,
            'ip_address' => $ip,
            'platform' => 'WEB'
        ]);
    }
}
