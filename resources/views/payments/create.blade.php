@extends('layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 my-5">
            <form class="needs-validation" method="post" action="{{ route('payments.store') }}" novalidate="">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="recipient">Цель платежа</label>
                        <input
                            type="text"
                            class="form-control @error('recipient') is-invalid @enderror"
                            id="recipient"
                            placeholder=""
                            required=""
                            name="recipient"
                        >
                        @error('recipient')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="value">Сумма платежа</label>
                        <input
                            type="text"
                            class="form-control @error('value') is-invalid @enderror"
                            id="value"
                            placeholder=""
                            required=""
                            name="value"
                        >
                        @error('value')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Продолжить</button>
            </form>
        </div>
    </div>
@endsection
