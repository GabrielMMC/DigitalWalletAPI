<?php

namespace App\Observers;

use App\Models\BankAccountLog;
use App\Models\UserLog;
use App\Models\Withdrawal;
use App\Models\WithdrawalLog;
use Illuminate\Support\Facades\Request;

class WithdrawalObserver
{
    public function created(Withdrawal $withdrawal)
    {
        $this->logWithdrawalAction($withdrawal, 'created');
    }

    public function updated(Withdrawal $withdrawal)
    {
        $this->logWithdrawalAction($withdrawal, 'updated');
    }

    public function deleted(Withdrawal $withdrawal)
    {
        $this->logWithdrawalAction($withdrawal, 'deleted');
    }

    protected function logWithdrawalAction(Withdrawal $withdrawal, $action)
    {
        $ip = Request::ip();
        WithdrawalLog::create([
            ...$withdrawal->toArray(),
            'withdrawal_id' => $withdrawal->id,
            'bank_account_log_id' => BankAccountLog::where('bank_account_id', $withdrawal->bank_account_id)->latest()->value('id'),
            'user_log_id' => UserLog::where('user_id', $withdrawal->user_id)->latest()->value('id'),
            'action' => $action,
            'ip_address' => $ip,
            'platform' => 'WEB'
        ]);
    }
}
