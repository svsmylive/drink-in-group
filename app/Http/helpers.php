<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

/**
 * @param array $errors
 * @param int $code
 *
 * @return JsonResponse
 */
function getErrors($errors = [], int $code = 400): JsonResponse
{
    return Response::json(['errors' => $errors], $code, [], JSON_UNESCAPED_UNICODE);
}

/**
 * @param array $data
 * @param int $code
 *
 * @return JsonResponse
 */
function getSuccessResponse(array $data = ['success' => true], $code = 200): JsonResponse
{
    return Response::json($data, $code, [], JSON_UNESCAPED_UNICODE + defined('JSON_INVALID_UTF8_IGNORE') ? 1048576 : 0);
}

/**
 * @return bool
 */
function checkDeliveryTime(): bool
{
    $startDelivery = 12;
    $endDelivery = 23;
    $now = (int)(now()->format('H'));
    if (!($now > $startDelivery && $now < $endDelivery)) {
        return false;
    }

    return true;
}

