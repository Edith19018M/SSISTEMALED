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
use App\Models\CategoriaUnidad;
use App\Models\UnidadProductiva;
use App\Models\Responsable;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Sistema para Coordinadores y Técnicos únicamente.
     */
    public function run(): void
    {
        // === CREAR ROLES ===
        $rolAdmin = Rol::create(['nombre_rol' => 'Administrador']);
        $rolCoordinador = Rol::create(['nombre_rol' => 'Coordinador']);
        $rolTecnico = Rol::create(['nombre_rol' => 'Técnico']);

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

        // === CREAR CATEGORÍAS DE UNIDADES PRODUCTIVAS ===
        $catUnidAlimentos = CategoriaUnidad::create([
            'nombre_categoria' => 'Producción de Alimentos',
            'carrera_asociada' => 'Gastronomía'
        ]);

        $catUnidTextil = CategoriaUnidad::create([
            'nombre_categoria' => 'Centro de Textiles',
            'carrera_asociada' => 'Diseño Textil'
        ]);

        // === CREAR UNIDADES PRODUCTIVAS ===
        $unid1 = UnidadProductiva::create([
            'nombre' => 'Laboratorio de Alimentos ITB',
            'categoria_id' => $catUnidAlimentos->id_categoria,
            'municipio_id' => $munLaPaz->id_municipio,
            'direccion' => 'Campus ITB, La Paz'
        ]);

        $unid2 = UnidadProductiva::create([
            'nombre' => 'Taller de Textiles UMSS',
            'categoria_id' => $catUnidTextil->id_categoria,
            'municipio_id' => $munCochabamba->id_municipio,
            'direccion' => 'Campus UMSS, Cochabamba'
        ]);

        // === CREAR RESPONSABLES ===
        $resp1 = Responsable::create([
            'nombre' => 'Ing. Pedro Flores',
            'contacto' => '591 7111111',
            'ci' => '9876543',
            'correo' => 'pflores@itb.edu.bo'
        ]);

        $resp2 = Responsable::create([
            'nombre' => 'Dra. Silvia Vargas',
            'contacto' => '591 7222222',
            'ci' => '5555555',
            'correo' => 'svargas@umss.edu.bo'
        ]);

        // === ASOCIAR RESPONSABLES A UNIDADES ===
        $unid1->responsables()->attach($resp1->id_responsable, [
            'fecha_inicio' => '2026-01-15',
            'fecha_fin' => null
        ]);

        $unid2->responsables()->attach($resp2->id_responsable, [
            'fecha_inicio' => '2026-02-01',
            'fecha_fin' => null
        ]);

        $this->command->info('✅ Base de datos poblada exitosamente con datos de prueba');
    }
}
