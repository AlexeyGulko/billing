<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckPaymentEpxiration;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\PaymentResolveRequest;
use App\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this
            ->middleware(CheckPaymentEpxiration::class)
            ->only(['resolve', 'show',])
        ;
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(CreatePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());
        return $request->wantsJson()
            ? response()->json(['url' => route('payments.show', $payment)])
            : response()->redirectTo(route('payments.show', $payment));
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function resolve(Payment $payment, PaymentResolveRequest $request)
    {
        $payment->update(['resolved_at' => Carbon::now()]);
        return $request->wantsJson()
            ? response()
            : response()->view('payments.success');
    }
}
