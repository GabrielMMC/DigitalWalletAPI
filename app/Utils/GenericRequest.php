<?php

namespace App\Utils;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class GenericRequest
{

  public static function GET($url)
  {
    try {
      $client = new Client();

      $response = $client->request('GET', $url, [
        'headers' => [
          'Accept' => 'application/json',
        ],
      ]);

      $responseData = json_decode($response->getBody(), true);

      return self::getResponse($responseData);
    } catch (RequestException $e) {
      return self::getException($e);
    }
  }

  // -------------------------*-------------------------
  public static function getResponse($response)
  {
    $error = $response->errors ?? $response->error ?? null;

    if ($error || !$response) {
      throw new Exception(json_encode($error));
    }

    return $response;
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

    Log::info('Error on Requests file: ' . json_encode($e->getMessage()));
  }
}
