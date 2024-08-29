<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoDocumento;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoDocumento>
 */
class TipoDocumentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=TipoDocumento::class;
    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'codigo' => $this->faker->unique()->bothify('???-####'),
        ];
    }
}
