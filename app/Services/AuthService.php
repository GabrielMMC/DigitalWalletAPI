<?php

namespace App\Services;

use App\Models\Recipient;
use App\Models\User;
use App\Requests\PaymentRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthService
{
  protected $service;

  public function __construct(RecipientService $recipientService)
  {
    $this->service = $recipientService;
  }

  public function getUser($data)
  {
    $user = User::firstWhere('email', '=', $data['email']);

    if (!isset($user) || !password_verify($data['password'], $user?->password)) {
      throw new Exception("Email ou senha incorretos");
    }

    $token = $user->createToken('token')->accessToken;

    return [...$user->toArray(), 'token' => $token];
  }

  public function createUser($data)
  {
    $hasEmail = User::where('email', '=', $data['email'])->exists();

    if ($hasEmail) {
      throw new Exception("Email em uso");
    }

    $user = new User();
    $user->fill($data)->save();

    $recipient = $this->service->createRecipient($user);

    if (!$recipient) {
      throw new Exception("Erro na criação de recebedor");
    }

    $token = $user->createToken('token')->accessToken;

    return [...$user->toArray(), 'token' => $token];
  }
}
