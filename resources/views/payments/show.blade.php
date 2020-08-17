@extends('layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4 my-5">
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6>Назначение</h6>
                        <small>{{ $payment->recipient }}</small>
                    </div>
                    <div>
                        <h6>Сумма</h6>
                        <small class="text-muted">{{ $payment->value }}</small>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="needs-validation" method="post" action="{{ route('payments.resolve', $payment) }}" novalidate="">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Имя владельца</label>
                        <input
                            type="text"
                            class="form-control @error('owner') is-invalid @enderror"
                            id="cc-name"
                            placeholder=""
                            required=""
                            name="owner"
                        >
                        <small class="text-muted">Полное имя владельца</small>
                        @error('owner')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">номер карты</label>
                        <input
                            type="text"
                            class="form-control @error('number') is-invalid @enderror"
                            id="cc-number"
                            placeholder=""
                            required=""
                            name="number"
                        >
                        @error('number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input
                            type="text"
                            class="form-control @error('expiration') is-invalid @enderror"
                            id="cc-expiration"
                            placeholder=""
                            required=""
                            name="expiration"
                        >
                        @error('expiration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input
                            type="text"
                            class="form-control @error('cvv') is-invalid @enderror"
                            id="cc-cvv"
                            placeholder=""
                            required=""
                            name="cvv"
                        >
                        @error('cvv')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
@endsection
