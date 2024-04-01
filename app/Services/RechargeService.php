<?php

namespace App\Services;

use App\Models\Recharge;
use App\Models\Recipient;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class RechargeService
{
  public function createRecharge($data)
  {
    $user = auth()->user();

    $recharge = new Recharge();
    $recharge->fill([...$data, 'user_id' => $user->id])->save();

    if (!$recharge) {
      throw new Exception("Erro na criação de cartão");
    }

    $recipient = Recipient::firstWhere('user_id', $user->id);
    $recipient->balance += $data['amount'];
    $recipient->save();

    return $recipient->balance;
  }
}
