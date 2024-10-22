<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), // Nombre aleatorio
            'description' => $this->faker->sentence(), // Descripción aleatoria
            'price' => $this->faker->randomFloat(2, 10, 1000), // Precio entre 10 y 1000
            'stock' => $this->faker->numberBetween(0, 100), // Stock entre 0 y 100
            'category_id' => $this->faker->numberBetween(1, 5), // ID de la categoría aleatorio
            'rating' => $this->faker->randomFloat(1, 1, 5), // Calificación entre 1.0 y 5.0
        ];
    }
}