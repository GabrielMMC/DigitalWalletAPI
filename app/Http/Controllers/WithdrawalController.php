<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawalRequest;
use App\Services\WithdrawalService;
use App\Utils\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    protected $service;
    public function __construct(WithdrawalService $withdrawalService)
    {
        $this->service = $withdrawalService;
    }

    public function create(WithdrawalRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $newBalance = $this->service->createWithdrawal($data);

            DB::commit();
            return response()->json($newBalance, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return ExceptionHandler::handle($e);
        }
    }
}
