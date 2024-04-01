<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use App\Services\RecipientService;
use App\Utils\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecipientController extends Controller
{
    protected $service;
    public function __construct(RecipientService $recipientService)
    {
        $this->service = $recipientService;
    }

    public function balance()
    {
        try {
            $user = auth()->user();
            $balance = $this->service->getBalance($user->id);

            return response()->json(['amount' => $balance], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }

    public function transfer($userRecipient)
    {
        try {
            $user = auth()->user();
            $balance = $this->service->transferAmount($user->id, $userRecipient);

            return response()->json(['amount' => $balance], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }

    public function testStripe()
    {
        return $this->service->createTopUp();
    }
}
