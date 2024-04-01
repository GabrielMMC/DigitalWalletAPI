<?php

namespace App\Observers;

use App\Models\BankAccount;
use App\Models\BankAccountLog;
use App\Models\UserLog;
use Illuminate\Support\Facades\Request;

class BankAccountObserver
{
    public function created(BankAccount $bankAccount)
    {
        $this->logBankAccountAction($bankAccount, 'created');
    }

    public function updated(BankAccount $bankAccount)
    {
        $this->logBankAccountAction($bankAccount, 'updated');
    }

    public function deleted(BankAccount $bankAccount)
    {
        $this->logBankAccountAction($bankAccount, 'deleted');
    }

    protected function logBankAccountAction(BankAccount $bankAccount, $action)
    {
        $ip = Request::ip();
        BankAccountLog::create([
            ...$bankAccount->toArray(),
            'bank_account_id' => $bankAccount->id,
            'user_log_id' => UserLog::where('user_id', $bankAccount->user_id)->latest()->value('id'),
            'action' => $action,
            'ip_address' => $ip,
            'platform' => 'WEB'
        ]);
    }
}
