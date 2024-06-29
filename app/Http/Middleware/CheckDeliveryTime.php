<?php

namespace App\Http\Middleware;

use App\Models\Institution;
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
        $institution = Institution::findOrFail($request->input('institution_id'));

        if ($this->checkDelivery($institution)) {
            if ($institution->type == 'Кулинария') {
                $msg = 'Доставка работает с 09:00 до 20:00, будем рады видеть вас в следующий раз!';
            } else {
                $msg = 'Доставка работает с 12:00 до 23:00, будем рады видеть вас в следующий раз!';
            }

            return response(["error" => $msg], 400);
        }

        return $next($request);
    }

    private function checkDelivery(Institution $institution): bool
    {
        if ($institution->type == 'Кулинария') {
            $startDelivery = 9;
            $endDelivery = 20;
        } else {
            $startDelivery = 12;
            $endDelivery = 23;
        }

        $nowHour = (int)(now()->format('H'));
        $nowMinutes = (int)(now()->format('i'));

        if (($nowHour <= $startDelivery || $nowHour >= $endDelivery) && $nowMinutes > 0) {
            return false;
        }

        return true;
    }
}
