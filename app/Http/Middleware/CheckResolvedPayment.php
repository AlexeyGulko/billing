<?php

namespace App\Http\Middleware;

use Closure;

class CheckResolvedPayment
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
        if ($request->route('payment')->isResolved()) {
            return $request->wantsJson()
                ? response()->json(
                    [
                        'errors' =>
                            ['payment' => 'Payment already resolved.']
                    ],
                    422)
                : response()->view('payments.success');
        }
        return $next($request);
    }
}
