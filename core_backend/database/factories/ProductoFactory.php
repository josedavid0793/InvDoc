<?php

namespace Database\Factories;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Producto::class;
    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->sentence,
            'precio_unidad' => $this->faker->numberBetween(100, 10000), // Genera un número entre 100 y 10000
            'costo_unidad' => $this->faker->numberBetween(50, 5000), 
            'codigo' => $this->faker->unique()->numerify('PROD-####'), // Genera un código único como PROD-1234
            'cantidad_disponible' => $this->faker->numberBetween(0, 1000),
            'imagen' => $this->faker->imageUrl(),
            'categoria' => Categoria::inRandomOrder()->first()->nombre,
        ];
    }
}
