<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    // public function definition(): array
    // {
    //     return [
    //         'persona_primer_apellido'  => $this->faker->lastName(),
    //         'persona_segundo_apellido' => $this->faker->lastName(),
    //         'persona_nombres'          => $this->faker->firstName().' '.$this->faker->firstName(),
    //         'persona_ci'               => (string) $this->faker->unique()->numberBetween(1000000, 99999999),
    //     ];
    // }
    public function definition()
    {
        return [
            'persona_primer_apellido' => $this->faker->lastName,
            'persona_segundo_apellido' => $this->faker->lastName,
            'persona_nombres' => $this->faker->firstName,
            'persona_ci' => $this->faker->unique()->numerify('########'),
        ];
    }
}
