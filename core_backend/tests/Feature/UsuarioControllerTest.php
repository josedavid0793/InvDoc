<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Usuario;
use App\Models\TipoDocumento;
use App\Http\Controllers\UsuarioController;

class UsuarioControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_index_returns_all_usuarios()
    {
        TipoDocumento::factory()->count(3)->create();
        Usuario::factory()->count(3)->create();

        $response = $this->get('/api/usuarios');

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertIsArray($responseData[0]);
        $this->assertCount(3, $responseData[0]);
    }

    public function test_store_crear_nuevo_usuario()
    {
        TipoDocumento::factory()->create(['codigo' => 'C.C']);

        $data = [
            'nombres' => 'usuario nuevo',
            'apellidos' => 'prueba',
            'email' => 'usuario@test.com',
            'password' => 'password',
            'confirmar_password' => 'password',
            'tipo_documento' => 'C.C',
            'numero_documento' => '1030622270',
            'telefono' => 3120000000
        ];

        $response = $this->postJson('/api/usuarios', $data);
        $response->assertStatus(200)
            ->assertJsonFragment(['mensaje' => 'Se ha creado el usuario usuario nuevo']);
        $this->assertDatabaseHas('usuarios', ['email' => 'usuario@test.com']);
    }

    public function test_store_fallo_validacion()
    {
        $data = [
            'nombres' => '',
            'apellidos' => '',
        ];
        $response = $this->postJson('/api/usuarios', $data);
        $response->assertStatus(422)
            ->assertJsonStructure(['error', 'mensaje']);
    }

    public function test_store_error_en_base_de_datos()
    {
        TipoDocumento::factory()->create(['codigo' => 'C.C']);
        Usuario::factory()->create(['email' => 'usuarioexistente@gmail.com']);

        $data = [
            'nombres' => 'usuario nuevo',
            'apellidos' => 'prueba',
            'email' => 'usuarioexistente@gmail.com',
            'password' => 'password',
            'confirmar_password' => 'password',
            'tipo_documento' => 'C.C',
            'numero_documento' => '1030622270',
            'telefono' => 3120008800
        ];

        $response = $this->postJson('/api/usuarios', $data);
        $response->assertStatus(500)
            ->assertJsonStructure(['error', 'mensaje']);
    }

    public function test_store_falla_validacion_email_invalido()
    {
        TipoDocumento::factory()->create(['codigo' => 'C.C']);
        // Datos de prueba con email inválido
        $data = [
            'nombres' => 'Jose David',
            'apellidos' => 'Quintero',
            'email' => 'email@invalido',
            'password' => 'password',
            'confirmar_password' => 'password',
            'tipo_documento' => 'C.C',
            'numero_documento' => '1030622270',
            'telefono' => 3120000000
        ];

        $response = $this->postJson('/api/usuarios', $data);
        $response->assertStatus(422)
            ->assertJsonStructure(['error', 'mensaje']);
    }

    public function test_Usuario_Registro_confirmar_contraseña()
    {
        $userData = Usuario::factory()->make()->toArray();
        $password = $userData['confirmar_password']; // Guarda la contraseña sin encriptar
        
        unset($userData['confirmar_password']); // Elimina este campo ya que no se envía al controlador

        $response = $this->postJson('/api/usuario', array_merge($userData, [
            'password' => $password,
            'confirmar_password' => $password
        ]));

        $response->assertStatus(200)
                 ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('usuarios', [
            'email' => $userData['email'],
            'numero_documento' => $userData['numero_documento']
        ]);
    }

    public function test_show_return_todos_usuarios()
    {
        TipoDocumento::factory()->create(['codigo' => 'C.C']);
        $usuario = Usuario::factory()->create();
        // Realizar una petición al método show
        $response = $this->getJson("/api/usuarios/{$usuario->id}");

        $response->assertStatus(200)
            ->assertJson([
                'mensaje' => 'Se consulto el usuario ' . $usuario->nombres . ' de la base de datos',
                'data' => [
                    'id' => $usuario->id,
                    'nombres' => $usuario->nombres,
                    'apellidos' => $usuario->apellidos,
                    'email' => $usuario->email,
                    'tipo_documento' => $usuario->tipo_documento,
                    'numero_documento' => $usuario->numero_documento,
                    'telefono' => $usuario->telefono,
                ]
            ]);
    }

    public function test_show_return_usuario_no_existe()
    {
        $response = $this->getJson('/api/usuarios/999');
        $response->assertStatus(404);
    }

    public function test_update_usuario_existente(){
        TipoDocumento::factory()->create(['codigo' => 'C.C']);
        $usuario = Usuario::factory()->create();
        $data = [
            'nombres' => 'usuario actualizado',
            'apellidos' => 'prueba',
            'email' => 'usuarioexistente@gmail.com',
            'password' => 'password',
            'confirmar_password' => 'password',
            'tipo_documento' => 'C.C',
            'numero_documento' => '1030622270',
            'telefono' => 3120008800
        ];
        $response = $this->putJson("/api/usuarios/{$usuario->id}",$data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['mensaje' => 'Se ha actualizado el usuario usuario actualizado']);
    }
    public function test_update_no_existe_usuario(){
        TipoDocumento::factory()->create(['codigo' => 'C.C']);
        $usuario = Usuario::factory()->create();
        $data = [
            'nombres' => 'usuario actualizado',
            'apellidos' => 'prueba',
            'email' => 'usuarioexistente@gmail.com',
            'password' => 'password',
            'confirmar_password' => 'password',
            'tipo_documento' => 'C.C',
            'numero_documento' => '1030622270',
            'telefono' => 3120008800
        ];
        $response = $this->putJson("/api/usuarios/999",$data);
        $response->assertStatus(500);
    }

    public function test_update_validacion_fallida(){
        TipoDocumento::factory()->create(['codigo' => 'C.C']);
        $usuario = Usuario::factory()->create();
        $data = [
            'nombres' => '',
            'apellidos' => '',
            'tipo_documento' => 'C.C',
            'numero_documento' => '1030622270',
            'telefono' => 3120008800
        ];
        $response = $this->putJson("/api/usuarios/{$usuario->id}", $data);
        $response->assertStatus(422)
            ->assertJsonStructure(['error', 'mensaje']);
    }

    public function test_destroy_deletes_existente_usuarios()
    {
        TipoDocumento::factory()->create(['codigo' => 'C.C']);
        $usuario = Usuario::factory()->create();

        $response = $this->deleteJson("/api/usuarios/{$usuario->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['mensaje' => 'Se ha eliminado el usuario ' . $usuario->nombres.' de la base de datos']);
        
        $this->assertDatabaseMissing('usuarios', ['id' => $usuario->id]);
    }

    public function test_destroy_returns_not_found_error()
    {
        $response = $this->deleteJson('/api/usuarios/999');

        $response->assertStatus(404);
    }
}
