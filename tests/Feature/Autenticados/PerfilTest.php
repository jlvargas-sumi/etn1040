<?php

use App\Http\Controllers\Auth\PerfilController;
use App\Models\Usuario;
use App\Models\Persona;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

test('Verificación de redirección al login para usuarios no autenticados en perfil', function () {
    get(route('perfil'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de respuesta HTTP de la ruta perfil para usuarios autenticados', function () {
    $faker = \Faker\Factory::create();

    $persona = Persona::factory()->create([
        'persona_primer_apellido' => $faker->lastName,
        'persona_segundo_apellido' => $faker->lastName,
        'persona_nombres' => $faker->firstName,
        'persona_ci' => $faker->unique()->numerify('########'),
    ]);

    /** @var \App\Models\Usuario $usuario */
    $usuario = Usuario::factory()->create([
        'usuario_persona_id' => $persona->persona_id,
        'usuario_usuario' => $persona->persona_ci,
        'usuario_estado' => 1,
        'usuario_clave' => bcrypt('clave123'),
    ]);

    $nombreArchivoUnico = 'foto_test_' . time() . '_' . rand(1000, 9999) . '.jpg';

    $foto = \App\Models\Foto::create([
        'foto_persona_id' => $persona->persona_id,
        'foto_archivo' => $nombreArchivoUnico
    ]);

    actingAs($usuario, 'web');

    $informacionPersonal = (object)[
        'persona_id' => $persona->persona_id,
        'persona_primer_apellido' => $persona->persona_primer_apellido,
        'persona_segundo_apellido' => $persona->persona_segundo_apellido,
        'persona_nombres' => $persona->persona_nombres,
        'persona_ci' => $persona->persona_ci,
        'celular_pais_id' => '591',
        'celular_numero' => $faker->numerify('7#######'),
        'correo_direccion' => $faker->unique()->email,
        'domicilio_direccion' => $faker->address
    ];

    $response = $this
        ->withSession([
            'rolActivoUsuario' => (object)['rol_nombre' => 'Estudiante'],
            'datosPersona' => $informacionPersonal,
            'rolesUsuario' => [],
            'nombreFotoPerfil' => $foto,
            'aperturaActiva' => null,
        ])
        ->get(route('perfil'));

    $response->assertOk();
});

test('Verificación de controlador en la ruta perfil', function () {
    $action = app('router')->getRoutes()->getByName('perfil')->getActionName();
    expect($action)->toBe(PerfilController::class.'@indice');
});