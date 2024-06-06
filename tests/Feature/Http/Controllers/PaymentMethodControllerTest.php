<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaymentMethodController
 */
final class PaymentMethodControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $paymentMethods = PaymentMethod::factory()->count(3)->create();

        $response = $this->get(route('payment-methods.index'));

        $response->assertOk();
        $response->assertViewIs('payment-methods.index');
        $response->assertViewHas('paymentMethods');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('payment-methods.create'));

        $response->assertOk();
        $response->assertViewIs('payment-methods.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentMethodController::class,
            'store',
            \App\Http\Requests\PaymentMethodStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->post(route('payment-methods.store'), [
            'name' => $name,
            'status' => $status,
            'user_id' => $user->id,
        ]);

        $paymentMethods = PaymentMethod::query()
            ->where('name', $name)
            ->where('status', $status)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $paymentMethods);
        $paymentMethod = $paymentMethods->first();

        $response->assertRedirect(route('payment-methods.index'));
    }


    #[Test]
    public function show_displays_view(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->get(route('payment-methods.show', $paymentMethod));

        $response->assertOk();
        $response->assertViewIs('payment-methods.show');
        $response->assertViewHas('paymentMethod');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->get(route('payment-methods.edit', $paymentMethod));

        $response->assertOk();
        $response->assertViewIs('payment-methods.edit');
        $response->assertViewHas('paymentMethod');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentMethodController::class,
            'update',
            \App\Http\Requests\PaymentMethodUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();
        $name = $this->faker->name();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->put(route('payment-methods.update', $paymentMethod), [
            'name' => $name,
            'status' => $status,
            'user_id' => $user->id,
        ]);

        $paymentMethod->refresh();

        $response->assertRedirect(route('payment-methods.index'));

        $this->assertEquals($name, $paymentMethod->name);
        $this->assertEquals($status, $paymentMethod->status);
        $this->assertEquals($user->id, $paymentMethod->user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->delete(route('payment-methods.destroy', $paymentMethod));

        $response->assertRedirect(route('payment-methods.index'));

        $this->assertModelMissing($paymentMethod);
    }
}
