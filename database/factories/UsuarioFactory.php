<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Foto;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {
        return [
            'usuario_persona_id' => Persona::factory(),
            'usuario_usuario' => $this->faker->unique()->userName,
            'usuario_clave' => Hash::make('password123'),
            'usuario_estado' => true,
        ];
    }

    // Estado para usuario con foto
    public function conFoto()
    {
        return $this->afterCreating(function (Usuario $usuario) {
            Foto::factory()->create([
                'foto_persona_id' => $usuario->usuario_persona_id
            ]);
        });
    }
}
