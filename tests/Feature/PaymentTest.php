<?php

namespace Tests\Feature;

use App\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_create_database_entry_payment()
    {
        $this->post(
            route('api.payments.store'),
            $payment = factory(Payment::class)->raw()
        );

        $this->assertDatabaseHas('payments', $payment);
    }

    public function test_create_payment_json_response()
    {
        $response = $this->postJson(
            route('api.payments.store'),
            factory(Payment::class)->raw()
        );

        $response->assertStatus(201);
    }

    public function test_resolve_payment()
    {
        $owner = $this->faker->firstName . ' ' . $this->faker->lastName;
        $payment = factory(Payment::class)->create();
        $response = $this->postJson(
            route('api.payments.resolve', $payment),
            [
                'owner'      => $owner,
                'number'     => $this->faker->creditCardNumber,
                'cvv'        => $this->faker->randomNumber(3),
                'expiration' => $this->faker->creditCardExpirationDateString,
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson(['resolved' => true]);
    }

    public function test_payment_resolved_middleware()
    {
        $owner = $this->faker->firstName . ' ' . $this->faker->lastName;
        $payment = factory(Payment::class)->create(['resolved_at' => Carbon::now()]);
        $response = $this->postJson(
            route('api.payments.resolve', $payment),
            [
                'owner'      => $owner,
                'number'     => $this->faker->creditCardNumber,
                'cvv'        => $this->faker->randomNumber(3),
                'expiration' => $this->faker->creditCardExpirationDateString,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('errors.payment', 'Payment already resolved.')
        ;
    }

    public function test_payment_session_time_out()
    {
        $owner = $this->faker->firstName . ' ' . $this->faker->lastName;
        $payment = factory(Payment::class)->create();
        $payment->created_at = Carbon::now()->subMinutes(35);
        $payment->save();
        $response = $this->postJson(
            route('api.payments.resolve', $payment),
            [
                'owner'      => $owner,
                'number'     => $this->faker->creditCardNumber,
                'cvv'        => $this->faker->randomNumber(3),
                'expiration' => $this->faker->creditCardExpirationDateString,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('errors.payment', 'Payment session is expires.')
        ;
    }

    public function test_get_all_success_payments_for_recent_time()
    {
        $payments = factory(Payment::class, 10)->create();
        $payments->each(function ($item) {
            $item->resolve();
        });

        $response = $this
            ->getJson(
                route(
                    'api.payments.index',
                    [
                        'from' => Carbon::now()->subDay(),
                        'to'   => Carbon::now()->addDay(),
                    ]
                )
            );

        $response
            ->assertStatus(200)
            ->assertJson($payments->toArray())
        ;
    }
}
