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
                        <input type="text" class="form-control" id="cc-name" placeholder="" required="" name="owner">
                        <small class="text-muted">Полное имя владельца</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">номер карты</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required="" name="number">
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required="" name="expiration">
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required="" name="cvv">
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
@endsection
