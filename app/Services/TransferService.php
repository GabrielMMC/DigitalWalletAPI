<?php

namespace App\Services;

use App\Events\SendBalance;
use App\Models\Recipient;
use App\Models\Transfer;
use App\Models\User;
use App\Requests\PaymentRequest;
use Exception;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class TransferService
{
  public function getUsers($request)
  {
    $user = auth()->user();

    return User::where('id', '!=', $user->id)
      ->where(function ($query) use ($request) {
        if (isset($request->search)) {
          $search_term = '%' . strtolower($request->search) . '%';
          $query->whereRaw('LOWER(name) LIKE ?', [$search_term]);
        }
      })->orderBy('name', 'asc')
      ->paginate(10);
  }

  public function getTransfers($request)
  {
    $user = auth()->user();
    return Transfer::where('user_sender_id', $user->id)
      ->orWhere('user_receiver_id', $user->id)
      ->with(['sender', 'receiver'])
      ->orderBy('created_at', 'desc')
      // ->where(function ($query) use ($request) {
      //   if (isset($request->search)) {
      //     $search_term = '%' . strtolower($request->search) . '%';
      //     $query->whereRaw('LOWER(name) LIKE ?', [$search_term]);
      //   }
      // })->orderBy('name', 'asc')
      ->paginate(10);
  }

  public function createTransfer($request)
  {
    $user = auth()->user();
    $sender = Recipient::firstWhere('user_id', $user->id);

    if ($sender->balance < $request->amount) {
      throw new Exception("O valor enviado deve ser maior do que o saldo da conta");
    }

    $recipient = Recipient::firstWhere('user_id', $request->user_id);
    $recipient->balance += $request->amount;
    $recipient->save();

    $sender->balance -= $request->amount;
    $sender->save();

    $transfer = new Transfer();
    $transfer->fill([
      'amount' => $request->amount,
      'user_sender_id' => $user->id,
      'user_receiver_id' => $recipient->user_id,
    ])->save();

    Event::dispatch(new SendBalance($recipient->user_id, $recipient->balance));

    return true;
  }
}
