<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankAccountRequest;
use App\Services\BankAccountService;
use App\Utils\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    protected $service;
    public function __construct(BankAccountService $bankAccountService)
    {
        $this->service = $bankAccountService;
    }

    public function list()
    {
        try {
            $accounts = $this->service->listBankAccounts();

            return response()->json($accounts, 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }

    public function create(BankAccountRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $newBalance = $this->service->createBankAccount($data);

            DB::commit();
            return response()->json($newBalance, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return ExceptionHandler::handle($e);
        }
    }
}
