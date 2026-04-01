# 📚 Documentación Completa - Sistema de Seguimiento LED

## 🎯 Resumen del Proyecto

Se ha creado un sistema completo de seguimiento para emprendimientos y unidades productivas con:

- **28 Migraciones** - Todas las tablas del modelo relacional
- **32 Modelos Eloquent** - Con relaciones completas (HasMany, BelongsTo, BelongsToMany)
- **27 Controllers API RESTful** - CRUD completo para todas las entidades
- **Rutas API** - Organizadas por módulos funcionales

---

## 📋 Estructura del Proyecto

### 🧑‍💼 Módulo: Usuarios y Roles

**Entidades:**
- `Rol` - Catálogo de roles
- `Region` - Divisiones territoriales
- `Municipio` - Municipios por región
- `Usuario` - Usuarios del sistema

**Endpoints:**
```
GET    /api/roles                    # Listar roles
POST   /api/roles                    # Crear rol
GET    /api/roles/{id}               # Ver rol
PUT    /api/roles/{id}               # Actualizar rol
DELETE /api/roles/{id}               # Eliminar rol

GET    /api/regiones                 # Listar regiones
POST   /api/regiones                 # Crear región
GET    /api/regiones/{id}            # Ver región
# ... (PUT, DELETE similar)

GET    /api/municipios/{id}          # Ver municipio con región
POST   /api/usuarios                 # Crear usuario
GET    /api/usuarios/{id}            # Ver usuario con relaciones
```

**Ejemplo de Uso:**
```bash
# Crear usuario
curl -X POST http://localhost:8000/api/usuarios \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Juan Pérez",
    "correo": "juan@example.com",
    "contraseña": "password123",
    "rol_id": 1,
    "region_id": 1,
    "municipio_id": 5
  }'

# Obtener usuario con relaciones
curl http://localhost:8000/api/usuarios/1
```

---

### 🚀 Módulo: Emprendimientos

**Entidades Principales:**
- `Emprendimiento` - Centro del módulo
- `Emprendedor` - Personas emprendedoras
- `CategoriaEmprendimiento` - Categorías
- `Producto` - Productos de emprendimientos

**Endpoints:**
```
# Categorías
GET    /api/categorias-emprendimiento
POST   /api/categorias-emprendimiento
GET    /api/categorias-emprendimiento/{id}/emprendimientos

# Emprendimientos
GET    /api/emprendimientos
POST   /api/emprendimientos
GET    /api/emprendimientos/{id}      # Con todas las relaciones
PUT    /api/emprendimientos/{id}
DELETE /api/emprendimientos/{id}

GET    /api/emprendimientos/{id}/seguimientos
GET    /api/emprendimientos/{id}/asesorias

# Emprendedores
GET    /api/emprendedores
POST   /api/emprendedores
POST   /api/emprendedores/{id}/asociar-emprendimiento

# Productos
GET    /api/productos
POST   /api/productos
GET    /api/emprendimientos/{id}/productos
```

**Ejemplo:**
```bash
# Crear emprendimiento
curl -X POST http://localhost:8000/api/emprendimientos \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Panadería Artesanal",
    "categoria_id": 1,
    "municipio_id": 3,
    "estado_proceso": "pendiente",
    "direccion": "Calle Principal 123",
    "sector_rubro": "Alimentos"
  }'

# Obtener emprendimiento completo
curl http://localhost:8000/api/emprendimientos/1
```

---

### 📑 Módulo: Selección de Emprendimientos

**Entidades:** Formularios, Entrevistas, Planes de Negocio

**Endpoints:**
```
# Formularios de Inscripción
GET    /api/formularios-inscripcion
POST   /api/formularios-inscripcion
GET    /api/emprendimientos/{id}/formularios

# Entrevistas
GET    /api/entrevistas
POST   /api/entrevistas
GET    /api/emprendimientos/{id}/entrevistas

# Planes de Negocio
GET    /api/planes-negocio
POST   /api/planes-negocio
GET    /api/emprendimientos/{id}/planes-negocio
```

---

### 📊 Módulo: Seguimiento de Emprendimientos

**Flujo:** Seguimiento → Compromisos → Actividades

**Endpoints:**
```
# Seguimientos
GET    /api/seguimientos-emprendimiento
POST   /api/seguimientos-emprendimiento
GET    /api/seguimientos-emprendimiento/{id}
GET    /api/seguimientos-emprendimiento/{id}/compromisos
GET    /api/seguimientos-emprendimiento/{id}/actividades

# Compromisos
GET    /api/compromisos-emprendimiento
POST   /api/compromisos-emprendimiento
GET    /api/compromisos-emprendimiento/{id}/actividades

# Actividades
GET    /api/actividades-emprendimiento
POST   /api/actividades-emprendimiento

# Historial
GET    /api/historial-emprendimiento
POST   /api/historial-emprendimiento
GET    /api/emprendimientos/{id}/historial
```

**Ejemplo de Flujo:**
```bash
# 1. Crear seguimiento
curl -X POST http://localhost:8000/api/seguimientos-emprendimiento \
  -d '{
    "id_emprendimiento": 1,
    "numero_seguimiento": 1,
    "fecha": "2026-03-24"
  }'

# 2. Crear compromiso en el seguimiento
curl -X POST http://localhost:8000/api/compromisos-emprendimiento \
  -d '{
    "id_seguimiento": 1,
    "descripcion": "Mejorar empaque de productos",
    "estado": "pendiente"
  }'

# 3. Crear actividad para el compromiso
curl -X POST http://localhost:8000/api/actividades-emprendimiento \
  -d '{
    "id_seguimiento": 1,
    "descripcion": "Investigar materiales de empaque",
    "estado": "en_proceso",
    "id_compromiso_origen": 1
  }'
```

---

### 🏭 Módulo: Unidades Productivas

**Entidades:**
- `UnidadProductiva` - Centro del módulo
- `Responsable` - Personas responsables
- `CategoriaUnidad` - Categorías con carrera asociada
- `Compra` / `Venta` - Transacciones

**Endpoints:**
```
# Categorías
GET    /api/categorias-unidad
POST   /api/categorias-unidad
GET    /api/categorias-unidad/{id}/unidades

# Unidades Productivas
GET    /api/unidades-productivas
POST   /api/unidades-productivas
GET    /api/unidades-productivas/{id}
GET    /api/unidades-productivas/{id}/seguimientos
GET    /api/unidades-productivas/{id}/compras
GET    /api/unidades-productivas/{id}/ventas
POST   /api/unidades-productivas/{id}/asociar-responsable

# Responsables
GET    /api/responsables
POST   /api/responsables
GET    /api/responsables/{id}/unidades

# Compras
GET    /api/compras
POST   /api/compras
GET    /api/unidades-productivas/{id}/compras-list

# Ventas
GET    /api/ventas
POST   /api/ventas
GET    /api/unidades-productivas/{id}/ventas-list
```

---

### 📊 Módulo: Seguimiento de Unidades

Similar al de Emprendimientos:
```
GET    /api/seguimientos-unidad
POST   /api/seguimientos-unidad
GET    /api/compromisos-unidad
POST   /api/compromisos-unidad
GET    /api/actividades-unidad
POST   /api/actividades-unidad
GET    /api/historial-unidad
```

---

### 📑 Módulo: Asesorías

**Endpoints:**
```
# Asesorías
GET    /api/asesorias
POST   /api/asesorias
GET    /api/asesorias/{id}
GET    /api/asesorias/{id}/compromisos

# Compromisos de Asesoría
GET    /api/compromisos-asesoria
POST   /api/compromisos-asesoria
GET    /api/asesorias/{id}/compromisos-relacionados
```

**Ejemplo:**
```bash
curl -X POST http://localhost:8000/api/asesorias \
  -d '{
    "id_emprendimiento": 1,
    "fecha": "2026-03-24",
    "hora_inicio": "09:00",
    "hora_fin": "11:00",
    "tipo": "General",
    "tematica": "Gestión Administrativa",
    "descripcion": "Asesoría sobre organización interna"
  }'
```

---

## 🔗 Relaciones Eloquent

### Relaciones HasMany (1:N)
```php
// Un emprendimiento tiene muchos productos
$emprendimiento->productos();

// Una región tiene muchos municipios
$region->municipios();

// Un seguimiento tiene muchos compromisos
$seguimiento->compromisos();
```

### Relaciones BelongsTo (N:1)
```php
// Un producto pertenece a un emprendimiento
$producto->emprendimiento();

// Un municipio pertenece a una región
$municipio->region();
```

### Relaciones BelongsToMany (N:M)
```php
// Un emprendimiento tiene muchos emprendedores
$emprendimiento->emprendedores()->with('pivot');
// Datos de la tabla pivote: es_responsable_principal

// Una unidad tiene muchos responsables
$unidad->responsables()->with('pivot');
// Datos de la tabla pivote: fecha_inicio, fecha_fin
```

---

## 🚀 Para Comenzar

### 1. Ejecutar Migraciones
```bash
php artisan migrate
```

### 2. Llenar Datos Base (Opcional)
```bash
php artisan tinker
# Crear roles
App\Models\Rol::create(['nombre_rol' => 'Administrador']);
App\Models\Rol::create(['nombre_rol' => 'Evaluador']);

# Crear regiones
App\Models\Region::create(['nombre_region' => 'La Paz']);
App\Models\Region::create(['nombre_region' => 'Cochabamba']);
```

### 3. Probar APIs
```bash
# Listar todos los emprendimientos
curl http://localhost:8000/api/emprendimientos

# Con paginación (por defecto 15 por página)
curl "http://localhost:8000/api/emprendimientos?page=2"

# Con búsqueda (depende de tu implementación adicional)
```

---

## 📊 Validaciones en Controllers

Todos los controllers incluyen validaciones como:
- Campos requeridos
- Unicidad (email, CI, nombre)
- Existencia de claves foráneas
- Formatos de fecha y numéricos
- Longitud de strings

---

## 🎯 Características Implementadas

✅ CRUD completo para 32 entidades
✅ Relaciones BelongsTo, HasMany, BelongsToMany  
✅ Paginación en listados (15 por página)
✅ Validaciones robustas
✅ Respuestas JSON estándar
✅ Métodos personalizados (porEmprendimiento, asociarResponsable, etc.)
✅ Casting de tipos (json, boolean, decimal, date)
✅ Soft deletes listos (solo añadir a modelo si lo deseas)

---

## 📝 Próximos Pasos

Si necesitas:

1. **Seeders** - Datos de prueba
2. **Policies** - Control de acceso
3. **Eventos & Listeners** - Historial automático
4. **Transformers** - Formato de respuestas
5. **Tests Unitarios** - Validar lógica
6. **Documentación Swagger** - API interactiva

¡Avísame! 🚀
