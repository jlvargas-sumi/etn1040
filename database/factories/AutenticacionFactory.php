<?php

namespace Tests;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait AutenticacionFactory
{
    /**
     * Crea un usuario autenticado con todos los datos necesarios
     */
    protected function crearUsuarioAutenticado(array $attributes = [])
    {
        // Datos por defecto para Usuario
        $defaults = [
            'usuario_id' => $attributes['usuario_id'] ?? 1,
            'usuario_persona_id' => $attributes['usuario_persona_id'] ?? 1,
            'usuario' => $attributes['usuario'] ?? 'testuser',
            'clave' => Hash::make('password123'),
            'remember_token' => Str::random(10),
        ];

        // Crear usuario
        $usuario = Usuario::factory()->create(array_merge($defaults, $attributes));

        // Crear registro en tabla personas
        DB::table('personas')->insert([
            'persona_id' => $usuario->usuario_persona_id,
            'persona_primer_apellido' => $attributes['persona_primer_apellido'] ?? 'Pérez',
            'persona_segundo_apellido' => $attributes['persona_segundo_apellido'] ?? 'Gómez',
            'persona_nombres' => $attributes['persona_nombres'] ?? 'Juan Carlos',
            'persona_ci' => $attributes['persona_ci'] ?? '1234567',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $usuario;
    }

    /**
     * Obtiene los datos de persona para la sesión
     */
    protected function getDatosPersonaSession($personaId = 1)
    {
        return (object)[
            'persona_primer_apellido' => 'Pérez',
            'persona_segundo_apellido' => 'Gómez',
            'persona_nombres' => 'Juan Carlos',
            'persona_ci' => '1234567',
            'persona_id' => $personaId
        ];
    }
}