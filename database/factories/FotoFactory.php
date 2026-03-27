<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Persona;
use App\Models\Foto;

class FotoFactory extends Factory
{
    protected $model = Foto::class;

    public function definition()
    {
        return [
            'foto_persona_id' => Persona::factory(),
            'foto_archivo' => $this->faker->lexify('foto-????????.jpg'),
        ];
    }
}
