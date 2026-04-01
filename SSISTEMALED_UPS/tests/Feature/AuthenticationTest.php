<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Region;
use App\Models\Municipio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private $rol;
    private $region;
    private $municipio;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear datos de prueba después de las migraciones de RefreshDatabase
        $this->rol = Rol::create(['nombre_rol' => 'Emprendedor']);
        $this->region = Region::create(['nombre_region' => 'La Paz']);
        $this->municipio = Municipio::create([
            'nombre_municipio' => 'La Paz',
            'id_region' => $this->region->id_region
        ]);

        Usuario::create([
            'nombre' => 'Test User',
            'correo' => 'test@example.com',
            'contraseña' => bcrypt('password123'),
            'rol_id' => $this->rol->id_rol,
            'region_id' => $this->region->id_region,
            'municipio_id' => $this->municipio->id_municipio
        ]);
    }

    /**
     * Prueba: Registro exitoso de usuario
     */
    public function test_user_can_register_successfully()
    {
        $response = $this->postJson('/api/auth/register', [
            'nombre' => 'New User',
            'correo' => 'newuser@example.com',
            'contraseña' => 'password123',
            'contraseña_confirmation' => 'password123',
            'rol_id' => $this->rol->id_rol,
            'region_id' => $this->region->id_region,
            'municipio_id' => $this->municipio->id_municipio
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Usuario registrado exitosamente'
            ]);

        $this->assertDatabaseHas('usuarios', [
            'correo' => 'newuser@example.com',
            'nombre' => 'New User'
        ]);
    }

    /**
     * Prueba: Registro falla con correo duplicado
     */
    public function test_user_cannot_register_with_duplicate_email()
    {
        $response = $this->postJson('/api/auth/register', [
            'nombre' => 'Another User',
            'correo' => 'test@example.com',
            'contraseña' => 'password123',
            'contraseña_confirmation' => 'password123',
            'rol_id' => $this->rol->id_rol,
            'region_id' => $this->region->id_region,
            'municipio_id' => $this->municipio->id_municipio
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    /**
     * Prueba: Login exitoso
     */
    public function test_user_can_login_successfully()
    {
        $response = $this->postJson('/api/auth/login', [
            'correo' => 'test@example.com',
            'contraseña' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Sesión iniciada correctamente'
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'usuario',
                'token'
            ]);
    }

    /**
     * Prueba: Login falla con contraseña incorrecta
     */
    public function test_user_cannot_login_with_wrong_password()
    {
        $response = $this->postJson('/api/auth/login', [
            'correo' => 'test@example.com',
            'contraseña' => 'wrongpassword'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ]);
    }

    /**
     * Prueba: Login falla con usuario inexistente
     */
    public function test_user_cannot_login_with_nonexistent_email()
    {
        $response = $this->postJson('/api/auth/login', [
            'correo' => 'nonexistent@example.com',
            'contraseña' => 'password123'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ]);
    }

    /**
     * Prueba: Obtener usuario autenticado
     */
    public function test_user_can_get_their_profile()
    {
        $usuario = Usuario::where('correo', 'test@example.com')->first();
        $token = $usuario->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/auth/me');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'usuario' => [
                    'correo' => 'test@example.com',
                    'nombre' => 'Test User'
                ]
            ]);
    }

    /**
     * Prueba: No puede acceder sin token
     */
    public function test_user_cannot_access_protected_route_without_token()
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    }

    /**
     * Prueba: Cambiar contraseña exitoso
     */
    public function test_user_can_change_password()
    {
        $usuario = Usuario::where('correo', 'test@example.com')->first();
        $token = $usuario->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/auth/change-password', [
                'contraseña_actual' => 'password123',
                'contraseña_nueva' => 'newpassword456',
                'contraseña_nueva_confirmation' => 'newpassword456'
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Contraseña cambiada exitosamente'
            ]);

        // Verificar que la contraseña se cambió
        $usuarioActualizado = Usuario::find($usuario->id_usuario);
        $this->assertTrue(bcrypt_verify('newpassword456', $usuarioActualizado->contraseña));
    }

    /**
     * Prueba: No puede cambiar contraseña con contraseña actual incorrecta
     */
    public function test_user_cannot_change_password_with_wrong_current_password()
    {
        $usuario = Usuario::where('correo', 'test@example.com')->first();
        $token = $usuario->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/auth/change-password', [
                'contraseña_actual' => 'wrongpassword',
                'contraseña_nueva' => 'newpassword456',
                'contraseña_nueva_confirmation' => 'newpassword456'
            ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'La contraseña actual es incorrecta'
            ]);
    }

    /**
     * Prueba: Logout exitoso
     */
    public function test_user_can_logout_successfully()
    {
        $usuario = Usuario::where('correo', 'test@example.com')->first();
        $token = $usuario->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Sesión cerrada exitosamente'
            ]);

        // Verificar que el token no funciona más
        $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/auth/me')
            ->assertStatus(401);
    }
}
