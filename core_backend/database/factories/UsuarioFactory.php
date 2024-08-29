<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\TipoDocumento;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Usuario::class;
    public function definition()
    {

        if (TipoDocumento::count() === 0) {
            TipoDocumento::factory()->create();
        }
        return [
            'nombres' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'tipo_documento' => TipoDocumento::inRandomOrder()->first()->codigo,
            'numero_documento' => $this->faker->numerify('##########'),
            'telefono' => $this->faker->unique()->e164PhoneNumber, // Genera un número de teléfono válido
        ];
    }
}
