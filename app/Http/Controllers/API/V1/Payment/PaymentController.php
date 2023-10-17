<?php

namespace App\Http\Controllers\API\V1\Payment;

use App\Constants\PaymentGateway;
use App\Http\Controllers\Controller;
use App\Integrations\Doku;
use App\Traits\HasApiResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    use HasApiResponses;

    /**
     * API for making payment base on payment gateway.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $dokuName = PaymentGateway::DOKU;
            $gateway = $request->gateway ?? $dokuName;

            switch ($gateway) {
                case $dokuName:
                    $doku = new Doku();
                    $checkout = $doku->checkout([]);
                    $data = [
                        'checkout' => $checkout,
                    ];

                    return $this->success(
                        code: Response::HTTP_OK,
                        message: 'Payment checkout generated successfully.',
                        data: $data
                    );
                    //
                default:
                    throw new Exception('Invalid payment gateway.');
            }
        }
        //
        catch (\Throwable $error) {
            return $this->failed(
                code: $error->getCode(),
                message: $error->getMessage(),
                errors: $error->getTrace(),
            );
        }
    }

    /**
     * API for retrieving callback base on payment gateway.
     */
    public function callback(Request $request): JsonResponse
    {
        try {
            $dokuSlug = PaymentGateway::slug(PaymentGateway::DOKU);
            $gateway = $request->gateway ?? $dokuSlug;

            switch ($gateway) {
                case $dokuSlug:
                    $doku = new Doku();
                    $response = $doku->notification($request);

                    return $this->success('Payment callback executed successfully.', $response);
                    //
                default:
                    throw new Exception('Invalid payment gateway.');
            }
        }
        //
        catch (\Throwable $error) {
            return $this->failed(
                code: $error->getCode(),
                message: $error->getMessage(),
                errors: $error->getTrace(),
            );
        }
    }
}
