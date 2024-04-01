<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Services\AddressService;
use App\Utils\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    protected $service;

    public function __construct(AddressService $addressService)
    {
        $this->service = $addressService;
    }

    public function list()
    {
        try {
            $addresses = $this->service->listAddresses();

            return response()->json($addresses, 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }

    public function create(AddressRequest $request)
    {
        try {
            $data = $request->validated();
            $address = $this->service->createAddress($data);

            return response()->json($address, 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e);
        }
    }
}
