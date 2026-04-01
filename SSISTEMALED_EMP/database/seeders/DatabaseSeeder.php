<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Region;
use App\Models\Municipio;
use App\Models\Usuario;
use App\Models\CategoriaEmprendimiento;
use App\Models\Emprendimiento;
use App\Models\Emprendedor;
use App\Models\Producto;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Sistema SSISTEMALED_EMP — Seguimiento de Emprendedores.
     */
    public function run(): void
    {
        // === CREAR ROLES ===
        $rolAdmin = Rol::create(['nombre_rol' => 'Administrador']);
        $rolCoordinador = Rol::create(['nombre_rol' => 'Coordinador']);
        $rolTecnico = Rol::create(['nombre_rol' => 'Técnico']);
        $rolEmprendedor = Rol::create(['nombre_rol' => 'Emprendedor']);

        // === CREAR REGIONES ===
        $regionLaPaz = Region::create(['nombre_region' => 'La Paz']);
        $regionCochabamba = Region::create(['nombre_region' => 'Cochabamba']);
        $regionSantaCruz = Region::create(['nombre_region' => 'Santa Cruz']);

        // === CREAR MUNICIPIOS ===
        $munLaPaz = Municipio::create([
            'nombre_municipio' => 'La Paz',
            'id_region' => $regionLaPaz->id_region
        ]);
        $munElAlto = Municipio::create([
            'nombre_municipio' => 'El Alto',
            'id_region' => $regionLaPaz->id_region
        ]);
        $munCochabamba = Municipio::create([
            'nombre_municipio' => 'Cochabamba',
            'id_region' => $regionCochabamba->id_region
        ]);
        $munSantaCruz = Municipio::create([
            'nombre_municipio' => 'Santa Cruz',
            'id_region' => $regionSantaCruz->id_region
        ]);

        // === CREAR USUARIOS ===
        Usuario::create([
            'nombre' => 'Admin Sistema',
            'correo' => 'admin@sseguimiento.com',
            'contraseña' => Hash::make('admin123'),
            'rol_id' => $rolAdmin->id_rol,
            'region_id' => $regionLaPaz->id_region,
            'municipio_id' => $munLaPaz->id_municipio
        ]);

        Usuario::create([
            'nombre' => 'Carlos Coordinador',
            'correo' => 'coordinador@sseguimiento.com',
            'contraseña' => Hash::make('coord123'),
            'rol_id' => $rolCoordinador->id_rol,
            'region_id' => $regionCochabamba->id_region,
            'municipio_id' => $munCochabamba->id_municipio
        ]);

        Usuario::create([
            'nombre' => 'Ana Técnica',
            'correo' => 'tecnico@sseguimiento.com',
            'contraseña' => Hash::make('tecnico123'),
            'rol_id' => $rolTecnico->id_rol,
            'region_id' => $regionLaPaz->id_region,
            'municipio_id' => $munLaPaz->id_municipio
        ]);

        // === CREAR CATEGORÍAS DE EMPRENDIMIENTOS ===
        $catTecnologia = CategoriaEmprendimiento::create([
            'nombre_categoria' => 'Tecnología e Innovación'
        ]);

        $catAlimentos = CategoriaEmprendimiento::create([
            'nombre_categoria' => 'Alimentos y Bebidas'
        ]);

        $catArtesania = CategoriaEmprendimiento::create([
            'nombre_categoria' => 'Artesanía y Manufactura'
        ]);

        // === CREAR EMPRENDIMIENTOS ===
        $emp1 = Emprendimiento::create([
            'nombre' => 'TechBolivia App',
            'categoria_id' => $catTecnologia->id_categoria,
            'municipio_id' => $munLaPaz->id_municipio,
            'estado_proceso' => 'activo',
            'direccion' => 'Zona Miraflores, La Paz',
            'sector_rubro' => 'Desarrollo de Software'
        ]);

        $emp2 = Emprendimiento::create([
            'nombre' => 'Sabores del Valle',
            'categoria_id' => $catAlimentos->id_categoria,
            'municipio_id' => $munCochabamba->id_municipio,
            'estado_proceso' => 'activo',
            'direccion' => 'Mercado La Cancha, Cochabamba',
            'sector_rubro' => 'Gastronomía'
        ]);

        // === CREAR EMPRENDEDORES ===
        $emp_person1 = Emprendedor::create([
            'codigo'           => 'E-2026Lp1',
            'id_emprendimiento' => $emp1->id_emprendimiento,
            'nombre'           => 'Luis',
            'apellidos'        => 'Mamani Quispe',
            'edad'             => 25,
            'sexo'             => 'M',
            'ci'               => '12345678',
            'celular'          => '591 7001234',
            'correo'           => 'lmamani@email.com',
            'direccion'        => 'La Paz',
            'carrera'          => 'Ingeniería de Sistemas',
            'año_estudio'      => '4to año',
        ]);

        $emp_person2 = Emprendedor::create([
            'codigo'           => 'E-2026Cb2',
            'id_emprendimiento' => $emp2->id_emprendimiento,
            'nombre'           => 'María',
            'apellidos'        => 'Condori Flores',
            'edad'             => 22,
            'sexo'             => 'F',
            'ci'               => '87654321',
            'celular'          => '591 7005678',
            'correo'           => 'mcondori@email.com',
            'direccion'        => 'Cochabamba',
            'carrera'          => 'Gastronomía',
            'año_estudio'      => '3er año',
        ]);

        // === CREAR USUARIOS EMPRENDEDORES (CI como correo y contraseña) ===
        Usuario::create([
            'nombre'         => $emp_person1->nombre . ' ' . $emp_person1->apellidos,
            'correo'         => $emp_person1->ci . '@emp.local',
            'contraseña'     => Hash::make($emp_person1->ci),
            'rol_id'         => $rolEmprendedor->id_rol,
            'emprendedor_id' => $emp_person1->id_emprendedor,
        ]);

        Usuario::create([
            'nombre'         => $emp_person2->nombre . ' ' . $emp_person2->apellidos,
            'correo'         => $emp_person2->ci . '@emp.local',
            'contraseña'     => Hash::make($emp_person2->ci),
            'rol_id'         => $rolEmprendedor->id_rol,
            'emprendedor_id' => $emp_person2->id_emprendedor,
        ]);

        // === CREAR PRODUCTOS ===
        Producto::create([
            'id_emprendimiento' => $emp1->id_emprendimiento,
            'nombre' => 'Aplicación Móvil de Pagos',
            'descripcion' => 'App para pagos QR en mercados locales'
        ]);

        Producto::create([
            'id_emprendimiento' => $emp2->id_emprendimiento,
            'nombre' => 'Salteñas Gourmet',
            'descripcion' => 'Salteñas con receta tradicional y sabores innovadores'
        ]);

        $this->command->info('✅ Base de datos SSISTEMALED_EMP poblada exitosamente con datos de prueba');
    }
}
