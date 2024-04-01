<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Card;
use App\Models\Recipient;
use App\Models\User;
use App\Requests\PaymentRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class CardService
{
  protected $service;

  public function __construct(DataValidationService $dataValidationService)
  {
    $this->service = $dataValidationService;
  }

  public function listCards()
  {
    $user = auth()->user();

    return Card::where('user_id', $user->id)->paginate(5)->items();
  }

  public function createCard($data)
  {
    $user = auth()->user();

    if (strlen($data['holder_document']) == 14) {
      $this->service->verifyCnpj($data['holder_document']);
    }

    $card = new Card();
    $card->fill([...$data, 'user_id' => $user->id])->save();

    if (!$card) {
      throw new Exception("Erro na criação de cartão");
    }

    return $card;
  }
}
