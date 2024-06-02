<?php

namespace App\Services;

use App\Contracts\Services\PaymentInterface;
use App\Models\Dish;
use App\Models\Institution;
use App\Repository\OrderRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class OrderService
{
    /**
     * @param OrderRepository $orderRepository
     * @param PaymentInterface $payment
     */
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly PaymentInterface $payment,
    ) {
    }

    /**
     * @param array $data
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function create(array $data): JsonResponse
    {
        $order = data_get($data, 'order');
        $amount = data_get($data, 'amount');
        $deliveryPrice = data_get($data, 'delivery');
        $userInfo = data_get($data, 'userInfo');
        $userInfo['typeOfDelivery'] = data_get($data, 'typeOfDelivery');
        $totalCost = 0;
        $institution = Institution::find($data['institution_id']);

        foreach ($order as $orderData) {
            $dish = Dish::find($orderData['id']);
            $totalCost += $dish?->price * $orderData['count'];
        }

        if ($totalCost === $amount) {
            $order = $this->orderRepository->create($order, $amount, $institution);
            $transactionData = $this->payment->createPayment((float)($amount + $deliveryPrice), options: $userInfo);
            $order->update(['transaction_id' => $transactionData['id']]);

            return response()->json(['confirmation_token' => $transactionData['token']]);
        }

        return response()->json(['Итоговая сумма не равна сумме позиций'], 400);
    }
}
