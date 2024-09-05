<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Categoria;

class CategoriaControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_index_returns_all_categorias()
    {
        // Arrange
        Categoria::factory()->count(3)->create();

        // Act
        $response = $this->get('/api/categorias');

        // Assert
        $response->assertStatus(200);
        $responseData = $response->json();
        $this->assertIsArray($responseData[0]);
        $this->assertCount(3, $responseData[0]);
    }

    public function test_store_crear_nueva_categoria()
    {
        $data = [
            'nombre' => 'Nueva Categoría',
            'descripcion' => 'Descripción de la nueva categoría',
        ];

        $response = $this->postJson('/api/categorias/crear', $data);
        $response->assertStatus(200)
            ->assertJsonFragment(['mensaje' => 'Se ha creado la categoría Nueva Categoría']);

        $this->assertDatabaseHas('categorias', ['nombre' => 'Nueva Categoría']);
    }
    public function test_store_validacion_error()
    {
        $data = [
            'nombre' => '', // Nombre vacío para disparar el error de validación
        ];

        $response = $this->postJson('/api/categorias/crear', $data);

        $response->assertStatus(422)
            ->assertJsonStructure(['error', 'mensaje']);
    }

   public function test_show_returns_especifica_categoria()
    {
        $categoria = Categoria::factory()->create();
        $response = $this->getJson("/api/categorias/{$categoria->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => $categoria->nombre]);
    }
    public function test_show_returns_not_found_error()
    {
        $response = $this->getJson('/api/categorias/999');

        $response->assertStatus(404);
    }

    public function test_update_modificar_existente_categorias()
    {
        $categoria = Categoria::factory()->create();

        $data = [
            'nombre' => 'Categoría Actualizada',
            'descripcion' => 'Nueva descripción',
        ];

        $response = $this->putJson("/api/categorias/{$categoria->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['mensaje' => 'Se ha actualizado la categoría Categoría Actualizada']);
        
        $this->assertDatabaseHas('categorias', ['nombre' => 'Categoría Actualizada']);
    }

    public function test_update_validacion_error()
    {
        $categoria = Categoria::factory()->create();

        $data = [
            'nombre' => '', // Nombre vacío para disparar el error de validación
        ];

        $response = $this->putJson("/api/categorias/{$categoria->id}", $data);

        $response->assertStatus(422)
                 ->assertJsonStructure(['error', 'mensaje']);
    }

    public function test_destroy_deletes_existente_categoria()
    {
        $categoria = Categoria::factory()->create();

        $response = $this->deleteJson("/api/categorias/{$categoria->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['mensaje' => 'Se ha eliminado la categoría ' . $categoria->nombre]);
        
        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
    }

    public function test_destroy_returns_not_found_error()
    {
        $response = $this->deleteJson('/api/categorias/999');

        $response->assertStatus(500);
    }

}
