<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Region;
use App\Models\Municipio;
use App\Models\CategoriaEmprendimiento;
use App\Models\Emprendimiento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmprendimientoTest extends TestCase
{
    use RefreshDatabase;

    protected $usuario;
    protected $token;
    protected $categoria;
    protected $municipio;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear datos básicos
        $rol = Rol::create(['nombre_rol' => 'Administrador']);
        $region = Region::create(['nombre_region' => 'La Paz']);
        $this->municipio = Municipio::create([
            'nombre_municipio' => 'La Paz',
            'id_region' => $region->id_region
        ]);

        // Crear usuario autenticado
        $this->usuario = Usuario::create([
            'nombre' => 'Admin User',
            'correo' => 'admin@test.com',
            'contraseña' => bcrypt('password123'),
            'rol_id' => $rol->id_rol,
            'region_id' => $region->id_region,
            'municipio_id' => $this->municipio->id_municipio
        ]);

        $this->token = $this->usuario->createToken('test-token')->plainTextToken;

        // Crear categoría
        $this->categoria = CategoriaEmprendimiento::create([
            'nombre_categoria' => 'Textiles'
        ]);
    }

    /**
     * Prueba: Listar emprendimientos
     */
    public function test_can_list_emprendimientos()
    {
        // Crear emprendimientos de prueba
        Emprendimiento::factory(3)->create([
            'municipio_id' => $this->municipio->id_municipio,
            'categoria_id' => $this->categoria->id_categoria
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson('/api/emprendimientos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id_emprendimiento',
                        'nombre',
                        'estado_proceso',
                        'categoria_id',
                        'municipio_id'
                    ]
                ]
            ]);
    }

    /**
     * Prueba: Crear emprendimiento exitosamente
     */
    public function test_can_create_emprendimiento()
    {
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson('/api/emprendimientos', [
                'nombre' => 'Nuevo Emprendimiento',
                'categoria_id' => $this->categoria->id_categoria,
                'municipio_id' => $this->municipio->id_municipio,
                'estado_proceso' => 'activo',
                'direccion' => 'Calle Principal 123',
                'sector_rubro' => 'Textiles'
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id_emprendimiento',
                    'nombre',
                    'estado_proceso'
                ]
            ]);

        $this->assertDatabaseHas('emprendimientos', [
            'nombre' => 'Nuevo Emprendimiento'
        ]);
    }

    /**
     * Prueba: Crear emprendimiento falla sin datos requeridos
     */
    public function test_cannot_create_emprendimiento_without_required_fields()
    {
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson('/api/emprendimientos', [
                'nombre' => 'Emprendimiento Sin Categoría'
            ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    /**
     * Prueba: Obtener detalle de emprendimiento
     */
    public function test_can_show_emprendimiento()
    {
        $emprendimiento = Emprendimiento::factory()->create([
            'municipio_id' => $this->municipio->id_municipio,
            'categoria_id' => $this->categoria->id_categoria
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson("/api/emprendimientos/{$emprendimiento->id_emprendimiento}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id_emprendimiento' => $emprendimiento->id_emprendimiento,
                    'nombre' => $emprendimiento->nombre
                ]
            ]);
    }

    /**
     * Prueba: Actualizar emprendimiento
     */
    public function test_can_update_emprendimiento()
    {
        $emprendimiento = Emprendimiento::factory()->create([
            'municipio_id' => $this->municipio->id_municipio,
            'categoria_id' => $this->categoria->id_categoria
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->putJson("/api/emprendimientos/{$emprendimiento->id_emprendimiento}", [
                'nombre' => 'Nombre Actualizado',
                'estado_proceso' => 'inactivo'
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('emprendimientos', [
            'id_emprendimiento' => $emprendimiento->id_emprendimiento,
            'nombre' => 'Nombre Actualizado'
        ]);
    }

    /**
     * Prueba: Eliminar emprendimiento
     */
    public function test_can_delete_emprendimiento()
    {
        $emprendimiento = Emprendimiento::factory()->create([
            'municipio_id' => $this->municipio->id_municipio,
            'categoria_id' => $this->categoria->id_categoria
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->deleteJson("/api/emprendimientos/{$emprendimiento->id_emprendimiento}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('emprendimientos', [
            'id_emprendimiento' => $emprendimiento->id_emprendimiento
        ]);
    }

    /**
     * Prueba: Obtener seguimientos de emprendimiento
     */
    public function test_can_get_emprendimiento_seguimientos()
    {
        $emprendimiento = Emprendimiento::factory()->create([
            'municipio_id' => $this->municipio->id_municipio,
            'categoria_id' => $this->categoria->id_categoria
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson("/api/emprendimientos/{$emprendimiento->id_emprendimiento}/seguimientos");

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    /**
     * Prueba: No autenticado no puede acceder
     */
    public function test_unauthenticated_user_cannot_access_emprendimientos()
    {
        $response = $this->getJson('/api/emprendimientos');

        $response->assertStatus(401);
    }
}
