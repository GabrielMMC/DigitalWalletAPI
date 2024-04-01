<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class PaymentService
{
  public static function makeRequest($url, $body, $callback = null)
  {
    try {
      $client = new Client();

      $response = $client->request('POST', env('PAYMENT_PROVIDER_URL') . $url, [
        'headers' => [
          'Accept' => 'application/json',
          'Content-Type' => 'application/json',
          'Authorization' => 'Basic ' . env('PAYMENT_PROVIDER_KEY'),
        ],
        'json' => $body,
      ]);

      $responseData = json_decode($response->getBody(), true);

      return self::getResponse($responseData, $callback);
    } catch (RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
        $statusCode = $response->getStatusCode();

        if ($statusCode == 422 && $response->getBody()) {
          $body = $response->getBody()->getContents();

          $responseData = json_decode($body, true);

          $message = isset($responseData['message'])
            ? $responseData['message']
            : 'Falha ao processar dados';

          return ['error' => $message];
        }

        if ($statusCode == 500) {
          return ['error' => 'Problemas ao estabelecer conexão, tente novamente em alguns minutos'];
        }
      }

      Log::info('Error on PaymentService file: ' . json_encode($e->getMessage()));

      return false;
    }
  }

  // -------------------------*-------------------------
  public static function getResponse($response, $callback = null)
  {
    $callback = $callback ?? function ($resp) {
      return $resp;
    };

    $error = $response->errors ?? $response->error ?? null;

    if ($error || !$response) {
      throw new Exception(json_encode($error));
    }

    return $callback($response);
  }
}
