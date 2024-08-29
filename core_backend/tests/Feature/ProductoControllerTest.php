<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Controllers\ProductoController;


class ProductoControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_index_returns_all_productos()
    {
        // Crear categorías primero
        Categoria::factory()->count(3)->create();
        // Arrange
        Producto::factory()->count(3)->create();

        //act
        $response = $this->get('/productos');

        //Asserts
        $response->assertStatus(200);
        $responseData = $response->json();
        $this->assertIsArray($responseData[0]);
        $this->assertCount(3, $responseData[0]);
    }

    public function test_create_crear_nuevo_producto()
    {
        Categoria::factory()->create(['nombre' => 'TestCategoria']);
        $data = [
            'nombre' => 'producto nuevo',
            'descripcion' => 'descripcion producto',
            'precio_unidad' => 2000,
            'costo_unidad' => 1000,
            'codigo' => 'TEST001',
            'cantidad_disponible' => 10,
            'imagen' => 'https://example.com/image.jpg',
            'categoria' => 'TestCategoria',
        ];

        $response = $this->postJson('/productos', $data);
        $response->assertStatus(200)
            ->assertJsonFragment(['mensaje' => 'Se ha creado el producto producto nuevo']);

        $this->assertDatabaseHas('productos', ['nombre' => 'producto nuevo']);
    }
    public function test_create_producto_validacion_fails()
    {
        $data = [
            'nombre' => '', // Nombre vacío, debería fallar la validación
            'precio_unidad' => 'no es un número', // Debería fallar la validación
        ];

        $response = $this->postJson('/productos', $data);

        $response->assertStatus(422)
            ->assertJsonStructure(['error', 'mensaje']);
    }

    public function test_create_producto_database_error()
    {
        // Simulamos un error de base de datos forzando un duplicado de clave única
        Categoria::factory()->create(['nombre' => 'TestCategoria']);

        Producto::factory()->create(['nombre' => 'Producto Duplicado']);

        $data = [
            'nombre' => 'Producto Duplicado',
            'descripcion' => 'Descripción',
            'precio_unidad' => 100,
            'costo_unidad' => 50,
            'codigo' => 'TEST001',
            'cantidad_disponible' => 10,
            'imagen' => 'https://example.com/image.jpg',
            'categoria' => 'TestCategoria'
        ];

        $response = $this->postJson('/productos', $data);

        $response->assertStatus(500)
            ->assertJsonStructure(['error', 'mensaje']);
    }

    public function test_show_returns_productos_data_cuando_producto_existe()
    {
        // Crear un producto de ejemplo en la base de datos de prueba
        Categoria::factory()->create(['nombre' => 'TestCategoria2']);
        $producto = Producto::factory()->create();

        // Realizar una petición al método show
        $response = $this->getJson("/productos/{$producto->id}");

        // Verificar que la respuesta es exitosa y contiene los datos esperados
        $response->assertStatus(200)
            ->assertJson([
                'mensaje' => 'Se consulto el producto ' . $producto->nombre . ' de la base de datos',
                'data' => [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'precio_unidad' => $producto->precio_unidad,
                    'costo_unidad' => $producto->costo_unidad,
                    'codigo' => $producto->codigo,
                    'cantidad_disponible' => $producto->cantidad_disponible,
                    'imagen' => $producto->imagen,
                    'categoria' => 'TestCategoria2'
                ]
            ]);
    }

    /** @test */
    public function test_show_returns_un_error_cuando_producto_no_existe()
    {
        // Realizar una petición al método show con un ID que no existe
        $response = $this->getJson('/productos/999');

        // Verificar que la respuesta tiene un error 404
        $response->assertStatus(404);
          //  ->assertJson(['error', 'mensaje']);
    }

    public function test_update_modificar_existente_producto(){

        Categoria::factory()->create(['nombre' => 'TestCategoria']);

        $producto = Producto::factory()->create();

        $data = [
            'nombre' => 'Producto actualizado',
            'descripcion' => 'Descripción actualizada',
            'precio_unidad' => 100,
            'costo_unidad' => 50,
            'codigo' => 'TEST001',
            'cantidad_disponible' => 10,
            'imagen' => 'https://example.com/image.jpg',
            'categoria' => 'TestCategoria'
        ];

        $response = $this->putJson("/productos/{$producto->id}",$data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['mensaje' => 'Se ha actualizado el producto Producto actualizado']);
    }
    public function test_update_modificar_no_existente_producto(){
        Categoria::factory()->create(['nombre' => 'TestCategoria']);

        $producto = Producto::factory()->create();
 
         $data = [
             'nombre' => 'Producto actualizado',
             'descripcion' => 'Descripción actualizada',
             'precio_unidad' => 100,
             'costo_unidad' => 50,
             'codigo' => 'TEST001',
             'cantidad_disponible' => 10,
             'imagen' => 'https://example.com/image.jpg',
             'categoria' => 'TestCategoria'
         ];
         $response = $this->putJson("/productos/999",$data);

        $response->assertStatus(404);
    }
    public function test_update_validacion_fails_error (){

        Categoria::factory()->create(['nombre' => 'TestCategoria']);

        $producto = Producto::factory()->create();

        $data = [
            'nombre' => '',
            'descripcion' => 'Descripción actualizada',
            'precio_unidad' => 100,
            'costo_unidad' => 50,
            'codigo' => 'TEST001',
            'cantidad_disponible' => 10,
            'imagen' => 'https://example.com/image.jpg',
            'categoria' => 'TestCategoria'
        ];

        $response = $this->putJson("/productos/{$producto->id}",$data);

        $response->assertStatus(422)
                 ->assertJsonStructure(['error', 'mensaje']);
    }

    public function test_destroy_deletes_existente_productos()
    {
        $categoria = Categoria::factory()->create();
        $producto = Producto::factory()->create();

        $response = $this->deleteJson("/productos/{$producto->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['mensaje' => 'Se ha eliminado el producto ' . $producto->nombre.' de la base de datos']);
        
        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    public function test_destroy_returns_not_found_error()
    {
        $response = $this->deleteJson('/productos/999');

        $response->assertStatus(404);
    }
}
