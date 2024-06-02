<?php

namespace App\Repository;

use App\Models\Institution;
use App\Models\Order;

class OrderRepository
{
    /**
     * @param array $data
     * @param int $amount
     * @param Institution $institution
     * @return Order
     */
    public function create(array $data, int $amount, Institution $institution): Order
    {
        /**@var Order $order */
        $order = Order::create([
            'info' => json_encode($data),
            'amount' => $amount,
            'institution_id' => $institution->id,
        ]);

        return $order;
    }

}
