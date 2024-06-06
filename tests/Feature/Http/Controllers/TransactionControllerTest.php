<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TransactionController
 */
final class TransactionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $transactions = Transaction::factory()->count(3)->create();

        $response = $this->get(route('transactions.index'));

        $response->assertOk();
        $response->assertViewIs('transaction.index');
        $response->assertViewHas('transactions');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('transactions.create'));

        $response->assertOk();
        $response->assertViewIs('transaction.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'store',
            \App\Http\Requests\TransactionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $payment_method = PaymentMethod::factory()->create();
        $invoice_number = $this->faker->word();
        $description = $this->faker->text();
        $invoice_date = Carbon::parse($this->faker->dateTime());
        $number_of_unit = $this->faker->randomFloat(/** decimal_attributes **/);
        $unit_price = $this->faker->randomFloat(/** decimal_attributes **/);
        $total = $this->faker->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();
        $invoice_file = $this->faker->word();
        $remarks = $this->faker->word();

        $response = $this->post(route('transactions.store'), [
            'payment_method' => $payment_method->id,
            'invoice_number' => $invoice_number,
            'description' => $description,
            'invoice_date' => $invoice_date->toDateTimeString(),
            'number_of_unit' => $number_of_unit,
            'unit_price' => $unit_price,
            'total' => $total,
            'user_id' => $user->id,
            'invoice_file' => $invoice_file,
            'remarks' => $remarks,
            'payment_method_id' => $payment_method->id,
        ]);

        $transactions = Transaction::query()
            ->where('payment_method', $payment_method->id)
            ->where('invoice_number', $invoice_number)
            ->where('description', $description)
            ->where('invoice_date', $invoice_date)
            ->where('number_of_unit', $number_of_unit)
            ->where('unit_price', $unit_price)
            ->where('total', $total)
            ->where('user_id', $user->id)
            ->where('invoice_file', $invoice_file)
            ->where('remarks', $remarks)
            ->where('payment_method_id', $payment_method->id)
            ->get();
        $this->assertCount(1, $transactions);
        $transaction = $transactions->first();

        $response->assertRedirect(route('transaction.index'));
    }


    #[Test]
    public function show_displays_view(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('transaction.show');
        $response->assertViewHas('transaction');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.edit', $transaction));

        $response->assertOk();
        $response->assertViewIs('transaction.edit');
        $response->assertViewHas('transaction');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'update',
            \App\Http\Requests\TransactionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $transaction = Transaction::factory()->create();
        $payment_method = PaymentMethod::factory()->create();
        $invoice_number = $this->faker->word();
        $description = $this->faker->text();
        $invoice_date = Carbon::parse($this->faker->dateTime());
        $number_of_unit = $this->faker->randomFloat(/** decimal_attributes **/);
        $unit_price = $this->faker->randomFloat(/** decimal_attributes **/);
        $total = $this->faker->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();
        $invoice_file = $this->faker->word();
        $remarks = $this->faker->word();

        $response = $this->put(route('transactions.update', $transaction), [
            'payment_method' => $payment_method->id,
            'invoice_number' => $invoice_number,
            'description' => $description,
            'invoice_date' => $invoice_date->toDateTimeString(),
            'number_of_unit' => $number_of_unit,
            'unit_price' => $unit_price,
            'total' => $total,
            'user_id' => $user->id,
            'invoice_file' => $invoice_file,
            'remarks' => $remarks,
            'payment_method_id' => $payment_method->id,
        ]);

        $transaction->refresh();

        $response->assertRedirect(route('transaction.index'));

        $this->assertEquals($payment_method->id, $transaction->payment_method);
        $this->assertEquals($invoice_number, $transaction->invoice_number);
        $this->assertEquals($description, $transaction->description);
        $this->assertEquals($invoice_date->timestamp, $transaction->invoice_date);
        $this->assertEquals($number_of_unit, $transaction->number_of_unit);
        $this->assertEquals($unit_price, $transaction->unit_price);
        $this->assertEquals($total, $transaction->total);
        $this->assertEquals($user->id, $transaction->user_id);
        $this->assertEquals($invoice_file, $transaction->invoice_file);
        $this->assertEquals($remarks, $transaction->remarks);
        $this->assertEquals($payment_method->id, $transaction->payment_method_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->delete(route('transactions.destroy', $transaction));

        $response->assertRedirect(route('transaction.index'));

        $this->assertModelMissing($transaction);
    }
}
