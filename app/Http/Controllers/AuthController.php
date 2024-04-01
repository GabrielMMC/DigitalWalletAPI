<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use App\Utils\ExceptionHandler;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }

    public function login(AuthRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->service->getUser($data);

            return response()->json($user, 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }

    public function register(AuthRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $newUser = $this->service->createUser($data);

            DB::commit();
            return response()->json($newUser, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return ExceptionHandler::handle($e);
        }
    }

    public function me()
    {
        try {
            $user = auth()->user();

            $userModel = User::findOrFail($user->id);

            return response()->json($userModel, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return ExceptionHandler::handle($e);
        }
    }
}
