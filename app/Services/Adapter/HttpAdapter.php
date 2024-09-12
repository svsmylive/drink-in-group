<?php

namespace App\Services\Adapter;

use Illuminate\Http\Client\PendingRequest;

class HttpAdapter
{
    private const BASE_URL = '';

    /**
     * @param PendingRequest $httpClient
     */
    public function __construct(public PendingRequest $httpClient)
    {
        $this->httpClient->connectTimeout(180);
        $this->httpClient->retry(3, 5000, function (\Exception $exception) {
            if (
                $exception->getCode() == 0
                || substr((string)$exception->getCode(), 0, 1) == 5
            ) {
                return true;
            }
            return false;
        });
    }

    /**
     * @param string $uri
     * @param array $options
     * @return array|null
     */
    public function get(string $uri, array $options = []): array|null
    {
        $response = $this->httpClient->get(
            sprintf('%s%s', self::BASE_URL, $uri),
            $options
        );

        $body = $response->json();

        if (!empty($body)) {
            return $body;
        }

        return null;
    }

//    /**
//     * @param string $uri
//     * @param array $json
//     * @return array|null
//     * @throws GuzzleException
//     */
//    public function post(string $uri, array $json): array|null
//    {
//        $response = $this->httpClient->request(
//            'POST',
//            sprintf('%s%s', self::BASE_URL, $uri),
//            [
//                'headers' => [
//                    'Content-Type: application/json',
//                ],
//                $json,
//            ],
//        );
//
//        Log::info('Response code:' . $response->getStatusCode());
//
//        if ($response->getStatusCode() >= 400) {
//            throw new \Exception("Internal Server Error", $response->getStatusCode());
//        }
//
//        $body = $response->getBody();
//
//        if (!empty($body)) {
//            return json_decode($body, true);
//        }
//
//        return null;
//    }
}
