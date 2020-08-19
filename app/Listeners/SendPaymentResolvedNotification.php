<?php

namespace App\Listeners;

use App\Events\PaymentResolved;
use App\Notifications\PaymentResolved as PaymentResolvedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPaymentResolvedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentResolved  $event
     * @return void
     */
    public function handle(PaymentResolved $event)
    {
        $event->payment->notify(new PaymentResolvedNotification());
    }
}
