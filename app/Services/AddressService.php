<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Recipient;
use App\Models\User;
use App\Requests\PaymentRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class AddressService
{
  public function listAddresses()
  {
    $user = auth()->user();

    return Address::where('user_id', $user->id)->paginate(3)->items();
  }

  public function createAddress($data)
  {
    $user = auth()->user();

    $address = new Address();
    $address->fill([...$data, 'user_id' => $user->id])->save();

    if (!$address) {
      throw new Exception("Erro na criação de endereço");
    }

    return $address;
  }
}
