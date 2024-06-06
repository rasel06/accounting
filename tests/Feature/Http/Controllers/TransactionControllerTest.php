<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $payment_token = $this->faker->word();
        $total = $this->faker->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('transactions.store'), [
            'payment_token' => $payment_token,
            'total' => $total,
            'user_id' => $user->id,
            'post_id' => $post->id,
            'status' => $status,
        ]);

        $transactions = Transaction::query()
            ->where('payment_token', $payment_token)
            ->where('total', $total)
            ->where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $transactions);
        $transaction = $transactions->first();

        $response->assertRedirect(route('post.index'));
        $response->assertSessionHas('transaction.id', $transaction->id);
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
}
