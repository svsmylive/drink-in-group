<?php

namespace App\Services;

use App\Models\Dish;
use App\Models\Institution;
use App\Models\Order;
use App\Models\OrderCount;
use App\Services\Adapter\HttpAdapter;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TillypadService
{
    /**
     * @param HttpAdapter $client
     */
    public function __construct(private HttpAdapter $client)
    {
    }

    /**
     * @param Institution $institution
     * @return Collection|null
     * @throws GuzzleException
     */
    public function getMenu(Institution $institution): Collection|null
    {
        if ($institution->type == 'Кулинария') {
            $id = 'AE3DF162-F2C2-4A4D-BE25-1E15AC96B568';
        } else {
            $id = 'C6405C88-300C-9E40-99AC-D10D64ABBA3C';
        }

        $response = $this->client->get(config('tillypad.url') . '/get-menu?sale-property-id=' . $id);

        if (!$response) {
            return null;
        }

        return collect($response);
    }

    /**
     * @param string $categoryGuid
     * @return array|null
     * @throws GuzzleException
     */
    public function getCategory(string $categoryGuid): array|null
    {
        $response = $this->client->get(config('tillypad.url') . '/get-menu?id=' . $categoryGuid);

        if (!$response) {
            return null;
        }

        return $response['MenuGroups'][0] ?? null;
    }

    /**
     * @param object $data
     * @param Order $order
     * @return void
     * @throws GuzzleException
     */
    public function sendOrder(object $data, Order $order): void
    {
        if (isset($data->firstName, $data->phone)) {
            $preparedOrder = $this->prepareOrder($data, $order);
            $response = Http::post(config('tillypad.url') . '/post-guest', $preparedOrder);

            Log::info('order gest_ID', [$response]);
        }
        /*if (isset($response['gest_ID'])) {
            $guestID = $response['gest_ID'];
            $this->createPayment($order, $guestID);
        }*/
    }

    /**
     * @param object $data
     * @param Order $order
     * @return array
     * @throws GuzzleException
     */
    public function prepareOrder(object &$data, Order $order): array
    {
        /**@var OrderCount $orderCount */
        $orderCount = OrderCount::where('institution_id', $order->institution_id)->first();
        $typeOfDelivery = $data->typeOfDelivery;
        $phone = $data->phone;
        $firstName = $data->firstName;
        $address = $data->address ?? '';
        $secondName = $data->secondName ?? '';
        $email = $data->email ?? '';
        $comment = $data->comment ?? '';
        if ($data->comment) {
            $comment .= "\n ОПЛАЧЕН НА САЙТЕ";
        }
        $dateOrder = Carbon::now()->format('Y-m-d\TH:i:s');
        $guest = $this->getGuest($phone);
        if (!$guest) {
            $this->createGuest($firstName, $secondName, $phone, $email);
        }
        $orders = [
            'ordr_orst_ID' => 0,
            'ordr_Date' => $dateOrder,
            'ordr_Name' => 'DS' . $orderCount->count,
            'orderItems' => []
        ];
        foreach (json_decode($order->info, true) as $id => $data) {
            $dish = Dish::find($id);
            $orders['orderItems'][] = [
                'orit_mitm_ID' => $dish->external_id,
                'orit_mvtp_ID' => $dish->mvtp_ID,
                'orit_Volume' => 1,
                'orit_Count' => $data['count'],
                'orit_Price' => $dish->price,
                'orit_VAT' => 0,
                'orit_PriceVat' => 0,
            ];
        }
        $prepareData = [
            'gest_gsst_ID' => 3,
            //статус подготовка
            'gest_Comment' => $comment,
            'gest_DateOpen' => $dateOrder,
            'gest_dvsn_ID' => '88971A81-082C-9143-9905-A0BC07FF2F21',
            //боевое подразделение cвое для камелота, кулинарии
//            'gest_dvsn_ID' => 'C21850A8-238E-B947-B9D0-CAF27739EDB1',
            'gest_ClientPhone' => $phone,
            'gest_Name' => 'DS' . $orderCount->count,
            // cвое для камелота, кулинарии
            'gest_ClientAddress' => $address,
            'gest_ClientName' => $firstName,
            'gest_IsDelivery' => 1,
            'guestDeliveries' => [
                'gsdlv_pytp_ID_Prepaid' => '',
                "gsdlv_dlvrst_ID" => 2,
                "gsdlv_dlvrmt_ID" => $typeOfDelivery,
                "gsdlv_cncpt_ID" => "E0434286-6DA2-7F47-814D-21F72151539F",
                "gsdlv_Date" => Carbon::parse($dateOrder)->addHour()->format('Y-m-d\TH:i:s'),
                "gsdlv_SendSooner" => 1,
                "gsdlv_NeedConfirmation" => 1,
            ],
            'orders' => [
                $orders
            ]
        ];
        $prepareData['guestDeliveries']['gsdlv_pytp_ID_Prepaid'] = '1A282341-6C84-6349-A211-8B2C651D3A34';

        $orderCount->update(['count' => ++$orderCount->count]);

        return $prepareData;
    }

    /**
     * @param string $phone
     * @return array|null
     * @throws GuzzleException
     */
    private function getGuest(string $phone): array|null
    {
        return $this->client->get(config('tillypad.url') . '/get-client-by-phone?phone=' . $phone);
    }

    /**
     * @param string $firstName
     * @param string $secondName
     * @param string $phone
     * @param string $email
     * @return void
     */
    private function createGuest(string $firstName, string $secondName, string $phone, string $email): void
    {
        $guestJson = [
            'clnt_clgr_ID' => '33D238E2-3F3C-3C43-A66A-FCDAFFB02232',
            'clnt_pepl_ID' => Str::uuid()->toString(),
            'clnt_Name' => $firstName . ' ' . $secondName,
            'clnt_isDisabled' => false,
            'clientPhones' => [
                [
                    'clph_Phone' => $phone
                ],
            ],
            'people' => [
                'pepl_FirstName' => $firstName,
                'pepl_SecondName' => $secondName,
                'pepl_EMail' => $email,
                'pepl_PhoneCell' => $phone,
            ]
        ];

        Http::post(config('tillypad.url') . '/post-client', $guestJson);
    }

//    /**
//     * @param Order $order
//     * @param string $guestID
//     * @return void
//     */
//    private function createPayment(Order $order, string $guestID): void
//    {
//        $payment = [
//            'Payment' => [
//                'gest_ID' => $guestID,
//                'paySum' => $order->amount,
//            ],
//        ];
//
//        $response = Http::post(config('tillypad.url') . '/pay-guest', $payment);
//
//        Log::info('payment response', [$response->body()]);
//    }
}
