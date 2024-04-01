<?php

namespace App\Http\Controllers;

use App\Http\Requests\RechargeRequest;
use App\Services\RechargeService;
use App\Utils\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RechargeController extends Controller
{
    protected $service;
    public function __construct(RechargeService $rechargeService)
    {
        $this->service = $rechargeService;
    }

    public function create(RechargeRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $newBalance = $this->service->createRecharge($data);

            DB::commit();
            return response()->json($newBalance, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return ExceptionHandler::handle($e);
        }
    }
}
