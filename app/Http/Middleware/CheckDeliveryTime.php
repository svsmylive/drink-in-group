<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDeliveryTime
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->checkDelivery()) {
            return response(["error" => "В данный момент доставка не работает"], 400);
        }

        return $next($request);
    }

    private function checkDelivery(): bool
    {
        $startDelivery = 12;
        $endDelivery = 23;
        $now = (int)(now()->format('H'));
        if (!($now > $startDelivery && $now < $endDelivery)) {
            return false;
        }

        return true;
    }
}
