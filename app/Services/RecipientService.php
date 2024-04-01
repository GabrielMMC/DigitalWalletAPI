<?php

namespace App\Services;

use App\Models\Recipient;
use App\Requests\PaymentRequest;

class RecipientService
{
  public function getBalance($userId)
  {
    return Recipient::where('user_id', $userId)->value('balance');

    // $recipientId = Recipient::where('user_id', $userId)->value('recipient_code');
    // return PaymentRequest::GET('/recipients/' . $recipientId . '/balance');
  }

  public function transferAmount($userId, $userRecipient)
  {
    return Recipient::where('user_id', $userId)->value('balance');

    // $recipientId = Recipient::where('user_id', $userId)->value('recipient_code');
    // return PaymentRequest::GET('/recipients/' . $recipientId . '/balance');
  }

  public function createRecipient($body)
  {
    // $response = PaymentRequest::POST('/recipients', $body);

    $recipient = new Recipient();
    $recipient->fill(['user_id' => $body->id])->save();

    return true;
  }
}
