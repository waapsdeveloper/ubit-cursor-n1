<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invite>
 */
class InviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'token' => \Illuminate\Support\Str::uuid(),
            'invited_by' => \App\Models\User::factory(['role' => 'admin']),
            'accepted_at' => fake()->optional()->dateTimeBetween('-1 week', 'now'),
            'expires_at' => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
