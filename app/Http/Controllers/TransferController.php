<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Http\Resources\TransferResource;
use App\Http\Resources\UserResource;
use App\Services\TransferService;
use App\Utils\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferController extends Controller
{
    protected $service;
    public function __construct(TransferService $transferService)
    {
        $this->service = $transferService;
    }

    public function users(Request $request)
    {
        try {
            $users = $this->service->getUsers($request);

            return response()->json([
                'collection' => UserResource::collection($users),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'total_pages' => $users->total(),
                    'per_page' => $users->perPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }

    public function historic(Request $request)
    {
        try {
            $historic = $this->service->getTransfers($request);

            return response()->json([
                'collection' => TransferResource::collection($historic),
                'pagination' => [
                    'current_page' => $historic->currentPage(),
                    'last_page' => $historic->lastPage(),
                    'total_pages' => $historic->total(),
                    'per_page' => $historic->perPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }

    public function transfer(TransferRequest $request)
    {
        DB::beginTransaction();
        try {
            $status = $this->service->createTransfer($request);

            DB::commit();
            return response()->json($status, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return ExceptionHandler::handle($e);
        }
    }
}
