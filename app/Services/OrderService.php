<?php

namespace App\Services;

use App\Contracts\Services\PaymentInterface;
use App\Models\Dish;
use App\Repository\OrderRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class OrderService
{
    /**
     * @param OrderRepository $orderRepository
     * @param PaymentInterface $payment
     * @param TillypadService $tillypadService
     */
    public function __construct(private OrderRepository $orderRepository, private PaymentInterface $payment, private TillypadService $tillypadService)
    {
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
        $isOnlinePayment = data_get($data, 'online');
        $userInfo = data_get($data, 'userInfo');
        $userInfo['typeOfDelivery'] = data_get($data, 'typeOfDelivery');
        $totalCost = 0;

        foreach ($order as $id => $orderData) {
            $dish = Dish::find($id);
            $totalCost += $dish?->price * $orderData['count'];
        }

        if ($totalCost === $amount) {
            $order = $this->orderRepository->create($order, $amount);
            if ($isOnlinePayment) {
                $transactionData = $this->payment->createPayment((float)($amount + $deliveryPrice), options: $userInfo);
                $order->update(['transaction_id' => $transactionData['id']]);

                return getSuccessResponse(['confirmation_token' => $transactionData['token']]);
            }
            $this->tillypadService->sendOrder((object)$userInfo, $order);

            return getSuccessResponse(['Заказ отправился во внутреннею систему']);
        }

        return getErrors(['Итоговая сумма не равна сумме позиций']);
    }
}
