<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verificado_em' => now(),
            'senha' => 'password',
            'perfil' => 'atendente',
            'remember_token' => Str::random(10),
        ];
    }

    public function administrador(): static
    {
        return $this->state(fn (array $attributes) => ['perfil' => 'administrador']);
    }

    public function atendente(): static
    {
        return $this->state(fn (array $attributes) => ['perfil' => 'atendente']);
    }

    public function enfermeira(): static
    {
        return $this->state(fn (array $attributes) => ['perfil' => 'enfermeira']);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verificado_em' => null,
        ]);
    }
}
