<?php

namespace App\Repository;

use App\Models\Order;

class OrderRepository
{
    /**
     * @param array $data
     * @param int $amount
     * @return Order
     */
    public function create(array $data, int $amount): Order
    {
        /**@var Order $order*/
        $order =  Order::create([
            'info' => json_encode($data),
            'amount' => $amount,
        ]);

        return $order;
    }

}
