<?php

namespace Database\Factories;

use App\Models\BidderApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BidderApplication>
 */
class BidderApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => $this->faker->phoneNumber(),
            'cnic' => $this->faker->numerify('#####-#######-#'),
            'deposit_amount' => config('auction.deposit_amount', 50000),
            'bank_name' => $this->faker->randomElement(['HBL', 'UBL', 'MCB', 'ABL', 'JS Bank']),
            'account_number' => $this->faker->numerify('####-####-####-####'),
            'transaction_id' => $this->faker->bothify('TXN-####-####-####'),
            'payment_proof' => null,
            'status' => $this->faker->randomElement(['pending', 'payment_verified', 'invitation_sent', 'approved']),
            'admin_notes' => $this->faker->optional()->sentence(),
            'payment_verified_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'invitation_sent_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'approved_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'verified_by' => null,
        ];
    }

    /**
     * Indicate that the application is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_verified_at' => null,
            'invitation_sent_at' => null,
            'approved_at' => null,
        ]);
    }

    /**
     * Indicate that the payment has been verified.
     */
    public function paymentVerified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'payment_verified',
            'payment_verified_at' => now(),
            'invitation_sent_at' => null,
            'approved_at' => null,
        ]);
    }

    /**
     * Indicate that the invitation has been sent.
     */
    public function invitationSent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'invitation_sent',
            'payment_verified_at' => now()->subDays(2),
            'invitation_sent_at' => now(),
            'approved_at' => null,
        ]);
    }

    /**
     * Indicate that the application has been approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'payment_verified_at' => now()->subDays(3),
            'invitation_sent_at' => now()->subDays(1),
            'approved_at' => now(),
        ]);
    }
}
