<?php

namespace App\Services\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class HttpAdapter
{
    private const BASE_URL = '';

    /**
     * @param Client $httpClient
     */
    public function __construct(public Client $httpClient){}

    /**
     * @param string $uri
     * @param array $options
     * @return array|null
     * @throws GuzzleException
     */
    public function get(string $uri, array $options = []): array|null
    {
        $response = $this->httpClient->request(
            'GET',
            sprintf('%s%s', self::BASE_URL, $uri),
            $options
        );

        $body = $response->getBody();

        if (!empty($body)) {
            return json_decode($body, true);
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
