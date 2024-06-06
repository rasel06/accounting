<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PaymentMethod;
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
            'payment_method' => PaymentMethod::factory(),
            'invoice_number' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'description' => $this->faker->text(),
            'user_id' => User::factory(),
            'invoice_date' => $this->faker->dateTime(),
            'invoice_file' => $this->faker->regexify('[A-Za-z0-9]{120}'),
            'number_of_unit' => $this->faker->randomFloat(2, 0, 999999.99),
            'unit_price' => $this->faker->randomFloat(2, 0, 999999.99),
            'total' => $this->faker->randomFloat(2, 0, 999999.99),
            'remarks' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'payment_method_id' => PaymentMethod::factory(),
        ];
    }
}
