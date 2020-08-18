<?php

namespace App\Http\Middleware;

use Closure;

class CheckPaymentEpxiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route('payment')->isExpired()) {
            return $request->wantsJson()
                ? response()->json('Payment session is expired.', 422)
                : response()->view('payments.timeout');
        }
        return $next($request);
    }
}
