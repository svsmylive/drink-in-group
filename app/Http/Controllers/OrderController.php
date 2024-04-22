<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Services\OrderService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * @param OrderService $orderService
     */
    public function __construct(private OrderService $orderService)
    {
    }

    /**
     * @param CreateOrderRequest $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function create(CreateOrderRequest $request): JsonResponse
    {
        return $this->orderService->create($request->validated());
    }
}
