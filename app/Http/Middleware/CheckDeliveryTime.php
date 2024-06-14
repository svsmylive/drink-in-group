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
    public function handle(Request $request, Closhttps://gitlab.com/smorygo/statm/-/merge_requests/491#2a35721eeb4aa43cc8562d8323cca1753be04cc3ure $next)
    {
        if (!$this->checkDelivery($request)) {
            return response(["error" => "В данный момент доставка не работает"], 400);
        }

        return $next($request);
    }

    private function checkDelivery(Request $request): bool
    {
        $institution = Institution::findOrFail($request->input('institution_id'));

        if ($institution->name == 'КУЛИНАРИЯ') {
            $startDelivery = 9;
            $endDelivery = 20;
        } else {
            $startDelivery = 12;
            $endDelivery = 23;
        }

        $now = (int)(now()->format('H'));

        if (!($now > $startDelivery || $now < $endDelivery)) {
            return false;
        }

        return true;
    }
}
