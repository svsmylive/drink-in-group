<?php

namespace App\Services;

use App\Contracts\Services\PaymentInterface;
use App\Models\Dish;
use App\Models\Institution;
use App\Models\Order;
use App\Repository\OrderRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

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
        $userInfo['delivery'] = $deliveryPrice;
        $totalCost = 0;
        $institution = Institution::find($data['institution_id']);

        if ($userInfo['typeOfDelivery'] == 1 && $deliveryPrice == 0) {
            return response()->json(
                ['error' => "По вашему адресу не смогли рассчитать стоимость доставки, попробуйте выбрать адрес из выпадающего списка"],
                400
            );
        }

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

    public function sendTelegram(object $metaData, Order $order): void
    {
        $apiKey = config('telegram.api_key');
        $chatId = config('telegram.chat_id_krasnodar');

        $message = $this->getTelegramMessage($order, $metaData);

        // в группу drink in group krd
        Http::post("https://api.telegram.org/bot{$apiKey}/sendMessage", [
            'chat_id' => '-4281880650',
            'text' => $message,
        ]);

        Http::post("https://api.telegram.org/bot{$apiKey}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    private function getTelegramMessage(Order $order, object $metaData): string
    {
        $order->loadMissing('institution');
        $data = [
            'institution_name' => $order->institution->name,
            'institution_type' => $order->institution->type,
            'delivery_type' => $metaData->typeOfDelivery == 1 ? 'Доставка' : 'Самовывоз',
            'firstName' => $metaData->firstName,
            'phone' => $metaData->phone,
            'address' => $metaData->address ? $metaData->address = str_replace(
                ' null',
                ' № квартиры не указан',
                $metaData->address
            ) : '',
            'amount' => $order->amount,
            'comment' => $metaData->comment ?? '',
            'email' => $metaData->email ?? '',
            'secondName' => $metaData->secondName ?? '',
            'delivery' => $metaData->delivery ?? 0,
        ];

        $messageOut = 'Заказ с сайта' . "\n";
        $messageOut .= 'Заведение : ' . $data['institution_type'] . ' - ' . $data['institution_name'] . "\n";
        $messageOut .= 'Тип : ' . $data['delivery_type'] . "\n";
        $messageOut .= 'Имя клиента : ' . $data['secondName'] . $data['firstName'] . "\n";
        $messageOut .= 'Телефон : ' . $data['phone'] . "\n";

        if (!empty($data['email'])) {
            $messageOut .= 'Емайл : ' . $data['email'] . "\n";
        }

        $messageOut .= 'Сумма : ' . $data['amount'] . "\n";

        if ($data['delivery'] > 0) {
            $messageOut .= 'Цена за доставку : ' . $data['delivery'] . "\n";
        }

        if ($metaData->typeOfDelivery == 1) {
            $messageOut .= 'Адрес : ' . $data['address'] . "\n";
        }

        if (!empty($data['comment'])) {
            $messageOut .= 'Комментарий : ' . $data['comment'] . "\n";
        }


        return $messageOut;
    }
}
