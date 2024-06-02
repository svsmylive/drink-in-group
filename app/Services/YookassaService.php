<?php

namespace App\Services;

use App\Contracts\Services\PaymentInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;
use YooKassa\Common\Exceptions\ApiException;
use YooKassa\Common\Exceptions\BadApiRequestException;
use YooKassa\Common\Exceptions\ExtensionNotFoundException;
use YooKassa\Common\Exceptions\ForbiddenException;
use YooKassa\Common\Exceptions\InternalServerError;
use YooKassa\Common\Exceptions\NotFoundException;
use YooKassa\Common\Exceptions\ResponseProcessingException;
use YooKassa\Common\Exceptions\TooManyRequestsException;
use YooKassa\Common\Exceptions\UnauthorizedException;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\Payment\PaymentStatus;

class YookassaService implements PaymentInterface
{
    /**
     * @param TillypadService $tillypadService
     */
    public function __construct(private readonly TillypadService $tillypadService)
    {
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));

        return $client;
    }

    /**
     * @param float $amount
     * @param string $description
     * @param array $options
     * @return array|string[]
     * @throws ApiException
     * @throws BadApiRequestException
     * @throws ExtensionNotFoundException
     * @throws ForbiddenException
     * @throws InternalServerError
     * @throws NotFoundException
     * @throws ResponseProcessingException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    public function createPayment(float $amount, string $description = '', array $options = []): array
    {
        $client = $this->getClient();
        $payment = $client->createPayment([
            'amount' => [
                'value' => $amount,
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'embedded',
            ],
            'metadata' => $options,
            'capture' => false,
            'description' => $description,
        ],
            uniqid('', true)
        );

        $transactionData = array_merge(['id' => $payment->id],
            ['token' => $payment->getConfirmation()->getConfirmationToken()]);

        return $transactionData;
    }

    /**
     * @param array $data
     * @return void
     * @throws ApiException
     * @throws BadApiRequestException
     * @throws ExtensionNotFoundException
     * @throws ForbiddenException
     * @throws InternalServerError
     * @throws NotFoundException
     * @throws ResponseProcessingException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException|\GuzzleHttp\Exception\GuzzleException
     */
    public function callback(array $data): void
    {
        $notification = (isset($data['event']) && $data['event'] === PaymentStatus::SUCCEEDED)
            ? new NotificationSucceeded($data)
            : new NotificationWaitingForCapture($data);
        $payment = $notification->getObject();

        if (isset($payment->status)) {
            if ($payment->status === 'waiting_for_capture') {
                $this->getClient()->capturePayment([
                    'amount' => $payment->amount,
                ], $payment->id, uniqid('', true));
            }

            if ($payment->status === 'succeeded') {
                if ($payment->paid === true) {
                    $order = Order::findByTransactionId($payment->id);
                    $metadata = (object)$payment->metadata;
                    if (!$order) {
                        Log::info('По транзакции не возможно найти заказ', [$payment]);
                    } else {
                        $this->tillypadService->sendOrder($metadata, $order);
                    }
                }
            }
        }
    }
}
