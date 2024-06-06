<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Transaction;
use App\Models\User;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'payment_token' => $this->faker->regexify('[A-Za-z0-9]{40}'),
            'total' => $this->faker->randomFloat(2, 0, 999999.99),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'status' => $this->faker->randomElement(["pending","successful","failed"]),
        ];
    }
}
