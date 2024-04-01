<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\Recharge;
use App\Models\Recipient;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class BankAccountService
{
  public function listBankAccounts()
  {
    $user = auth()->user();

    return BankAccount::where('user_id', $user->id)->paginate(3)->items();
  }

  public function createBankAccount($data)
  {
    $user = auth()->user();

    $bankAccount = new BankAccount();
    $bankAccount->fill([...$data, 'user_id' => $user->id])->save();

    if (!$bankAccount) {
      throw new Exception("Erro na criação de conta bancaria");
    }

    return $bankAccount;
  }
}
