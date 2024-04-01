<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use App\Services\CardService;
use App\Utils\ExceptionHandler;
use Illuminate\Http\Request;

class CardController extends Controller
{
    protected $service;

    public function __construct(CardService $cardService)
    {
        $this->service = $cardService;
    }

    public function list()
    {
        try {
            $cards = $this->service->listCards();

            return response()->json($cards, 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }

    public function create(CardRequest $request)
    {
        try {
            $data = $request->validated();
            $card = $this->service->createCard($data);

            return response()->json($card, 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }
}
