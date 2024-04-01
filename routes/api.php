<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    "prefix" => "auth"
], function () {
    Route::group([
        "middleware" => "guest:api"
    ], function () {
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/register", [AuthController::class, "register"]);
    });
});

//-------------------------*-------------------------
Route::group([
    "prefix" => "user"
], function () {
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::get("/me", [AuthController::class, "me"]);
    });
});

//-------------------------*-------------------------
Route::group([
    "prefix" => "recipient"
], function () {
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::get("/testStripe", [RecipientController::class, "testStripe"]);
        Route::get("/balance", [RecipientController::class, "balance"]);
    });
});

//-------------------------*-------------------------
Route::group([
    "prefix" => "address"
], function () {
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::get("/list", [AddressController::class, "list"]);
        Route::post("/create", [AddressController::class, "create"]);
    });
});

//-------------------------*-------------------------
Route::group([
    "prefix" => "card"
], function () {
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::get("/list", [CardController::class, "list"]);
        Route::post("/create", [CardController::class, "create"]);
    });
});

//-------------------------*-------------------------
Route::group([
    "prefix" => "recharge"
], function () {
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::post("/create", [RechargeController::class, "create"]);
    });
});

//-------------------------*-------------------------
Route::group([
    "prefix" => "bank_account"
], function () {
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::get("/list", [BankAccountController::class, "list"]);
        Route::post("/create", [BankAccountController::class, "create"]);
    });
});

//-------------------------*-------------------------
Route::group([
    "prefix" => "withdrawal"
], function () {
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::get("/list", [WithdrawalController::class, "list"]);
        Route::post("/create", [WithdrawalController::class, "create"]);
    });
});

//-------------------------*-------------------------
Route::group([
    "prefix" => "transfer"
], function () {
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::post("/", [TransferController::class, "transfer"]);
        Route::get("/historic", [TransferController::class, "historic"]);
        Route::get("/users", [TransferController::class, "users"]);
    });
});
