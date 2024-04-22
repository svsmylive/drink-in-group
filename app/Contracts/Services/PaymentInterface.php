<?php

namespace App\Contracts\Services;

interface PaymentInterface
{
    /**
     * @return object
     */
    public function getClient(): object;

    /**
     * @param float $amount
     * @param string $description
     * @param array $options
     * @return array
     */
    public function createPayment(float $amount, string $description, array $options = []): array;

    /**
     * @param array $data
     * @return void
     */

    public function callback(array $data): void;

}

