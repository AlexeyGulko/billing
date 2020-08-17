<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\PaymentResolveRequest;
use App\Payment;

class PaymentController extends Controller
{
    public function create()
    {
        return view('index');
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
        return $request->wantsJson()
            ? response()->json($request->validated())
            : response()->redirectTo(route('payments.show', $payment));
    }
}
