<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\Recharge;
use App\Models\Recipient;
use App\Models\User;
use App\Models\Withdrawal;
use Exception;
use Illuminate\Support\Facades\Log;

class WithdrawalService
{
  public function getWithdrawals()
  {
    $user = auth()->user();

    return Withdrawal::where('user_id', $user->id)->paginate(10);
  }

  public function createWithdrawal($data)
  {
    $user = auth()->user();

    $withdrawal = new Withdrawal();
    $withdrawal->fill([...$data, 'user_id' => $user->id])->save();

    if (!$withdrawal) {
      throw new Exception("Erro na criação de saque");
    }

    $recipient = Recipient::firstWhere('user_id', $user->id);

    if ($data['amount'] > $recipient->balance) {
      throw new Exception("Valor acima do disponível");
    }

    $recipient->balance -= $data['amount'];
    $recipient->save();

    return $recipient->balance;
  }
}
