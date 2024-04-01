<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Card;
use App\Models\Recipient;
use App\Models\User;
use App\Requests\PaymentRequest;
use App\Utils\GenericRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class DataValidationService
{
  public function verifyCnpj($cnpj)
  {
    $isValid = GenericRequest::GET('https://api-publica.speedio.com.br/buscarcnpj?cnpj=' . $cnpj);
    // Log::info('cnpj' . json_encode($isValid));
    if (isset($isValid['error']) || !isset($isValid['STATUS']) || !$isValid['STATUS']) {
      throw new Exception("CNPJ inválido");
    }
    return $isValid['STATUS'] ?? false;
  }
}
