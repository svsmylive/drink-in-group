<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PaymentInterface;

class PaymentController extends Controller
{
    /**
     * @param PaymentInterface $paymentService
     */
    public function __construct(private PaymentInterface $paymentService){}

    /**
     * @return void
     */
    public function callback(): void
    {
        $source = file_get_contents('php://input');

        $data = json_decode($source, true);

        $this->paymentService->callback($data);
    }

}
