<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $senha = 'senha123';

        return [
            'nome' => $this->faker->name(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'senha' => Hash::make($senha),
            'password' => Hash::make($senha),
            'nivel_acesso' => $this->faker->randomElement(['admin', 'veterinario', 'cliente', 'operador']),
            'ativo' => true,
            'observacoes' => $this->faker->sentence(4),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }


}
