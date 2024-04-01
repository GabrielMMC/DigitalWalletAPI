<?php

namespace App\Requests;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class PaymentRequest
{
  public static function POST($url, $body, $callback = null)
  {
    try {
      $client = new Client();

      $response = $client->request('POST', env('PAYMENT_PROVIDER_URL') . $url, [
        'headers' => [
          'Accept' => 'application/json',
          'Content-Type' => 'application/json',
          'Authorization' => 'Basic ' . base64_encode(env('PAYMENT_PROVIDER_KEY'))
        ],
        'json' => $body,
      ]);

      $responseData = json_decode($response->getBody(), true);

      return self::getResponse($responseData, $callback);
    } catch (RequestException $e) {
      return self::getException($e);
    }
  }

  // -------------------------*-------------------------
  public static function GET($url, $callback = null)
  {
    try {
      $client = new Client();

      $response = $client->request('GET', env('PAYMENT_PROVIDER_URL') . $url, [
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => 'Basic ' . base64_encode(env('PAYMENT_PROVIDER_KEY')),
        ],
      ]);

      $responseData = json_decode($response->getBody(), true);

      return self::getResponse($responseData, $callback);
    } catch (RequestException $e) {
      return self::getException($e);
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

  // -------------------------*-------------------------
  public static function getException($e)
  {
    if (!$e->hasResponse()) {
      return false;
    }

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

    Log::info('Error on PaymentRequest file: ' . json_encode($e->getMessage()));
  }
}
