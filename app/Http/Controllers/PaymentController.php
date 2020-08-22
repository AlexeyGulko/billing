<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckPaymentEpxiration;
use App\Http\Middleware\CheckResolvedPayment;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\PaymentIndexRequest;
use App\Http\Requests\PaymentResolveRequest;
use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this
            ->middleware(CheckPaymentEpxiration::class)
            ->only(['resolve', 'show',])
        ;
        $this->middleware(CheckResolvedPayment::class)
            ->only(['resolve', 'show',])
        ;
    }

    public function index(PaymentIndexRequest $request )
    {
        $payments = Payment::resolved()
            ->to($request)
            ->from($request)
            ->get()
        ;
        return $request->wantsJson()
            ? response()->json($payments, 200)
            : $payments;
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(CreatePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());
        return $request->wantsJson()
            ? response()->json(['url' => route('payments.show', $payment)], 201)
            : response()->redirectTo(route('payments.show', $payment));
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function resolve(Payment $payment, PaymentResolveRequest $request)
    {
        $payment->resolve();
        return $request->wantsJson()
            ? response()->json(['resolved' => $payment->isResolved()], 200)
            : redirect()->back();
    }
}
