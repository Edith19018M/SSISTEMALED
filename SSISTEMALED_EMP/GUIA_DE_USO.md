# SSISTEMALED_EMP — Guía de Uso Completa
## Sistema de Seguimiento de Emprendedores

> **Versión:** 1.0 | **URL:** http://localhost:8000 | **Base de datos:** `ssistemaled_emp`

---

## Tabla de Contenidos

1. [Descripción General](#1-descripción-general)
2. [Roles y Permisos](#2-roles-y-permisos)
3. [Acceso al Sistema](#3-acceso-al-sistema)
4. [Dashboard](#4-dashboard)
5. [Módulo: Emprendimientos](#5-módulo-emprendimientos)
6. [Módulo: Emprendedores](#6-módulo-emprendedores)
7. [Módulo: Seguimientos](#7-módulo-seguimientos)
8. [Módulo: Asesorías](#8-módulo-asesorías)
9. [Módulo: Administración](#9-módulo-administración)
10. [API REST](#10-api-rest)
11. [Flujo de Trabajo Recomendado](#11-flujo-de-trabajo-recomendado)
12. [Preguntas Frecuentes](#12-preguntas-frecuentes)

---

## 1. Descripción General

**SSISTEMALED_EMP** es el sistema de seguimiento diseñado exclusivamente para la gestión de **emprendimientos y emprendedores**. Permite registrar emprendimientos, asociarles emprendedores, llevar un historial completo de seguimientos periódicos, registrar compromisos y actividades, y coordinar asesorías de apoyo.

### Qué permite hacer este sistema

- Registrar y gestionar emprendimientos con su información completa
- Administrar emprendedores y vincularlos a sus emprendimientos
- Registrar el proceso de selección (formularios, entrevistas, planes de negocio)
- Llevar seguimientos periódicos con compromisos y actividades
- Registrar asesorías técnicas con sus compromisos derivados
- Consultar el historial completo de cambios de cada emprendimiento
- Gestionar usuarios, roles y territorio (regiones/municipios)

---

## 2. Roles y Permisos

El sistema tiene **3 roles** con diferentes niveles de acceso:

### Tabla de Permisos

| Módulo / Acción | Administrador | Coordinador | Técnico |
|---|:---:|:---:|:---:|
| **Dashboard** — Ver | ✅ | ✅ | ✅ |
| **Emprendimientos** — Ver/Listar | ✅ | ✅ | ✅ |
| **Emprendimientos** — Crear / Editar / Eliminar | ✅ | ❌ | ❌ |
| **Emprendedores** — Ver/Listar | ✅ | ✅ | ✅ |
| **Emprendedores** — Crear / Editar / Eliminar | ✅ | ✅ | ✅ |
| **Seguimientos** — Ver/Listar | ✅ | ✅ | ✅ |
| **Seguimientos** — Crear / Gestionar compromisos y actividades | ✅ | ✅ | ✅ |
| **Seguimientos** — Eliminar | ✅ | ✅ | ✅ |
| **Asesorías** — Ver/Listar | ✅ | ✅ | ✅ |
| **Asesorías** — Crear / Editar / Eliminar | ✅ | ✅ | ❌ |
| **Asesorías** — Gestionar compromisos | ✅ | ✅ | ❌ |
| **Usuarios** — Gestionar | ✅ | ❌ | ❌ |
| **Categorías** — Gestionar | ✅ | ❌ | ❌ |
| **Territoriales** (Roles, Regiones, Municipios) | ✅ | ❌ | ❌ |

### Descripción de cada Rol

#### Administrador
Control total del sistema. Puede crear, editar y eliminar cualquier registro. Gestiona usuarios, roles, regiones, municipios y categorías. Es el único que puede crear o modificar emprendimientos.

#### Coordinador
Perfil operativo intermedio. Puede gestionar asesorías completas y registrar toda la actividad de seguimiento. No puede crear ni modificar emprendimientos directamente, ni administrar usuarios o configuraciones del sistema.

#### Técnico
Perfil de campo. Puede registrar seguimientos, agregar compromisos y actividades, y consultar toda la información del sistema. No puede crear asesorías ni modificar emprendimientos o configuraciones.

---

## 3. Acceso al Sistema

### Credenciales de Prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | `admin@sseguimiento.com` | `admin123` |
| Coordinador | `coordinador@sseguimiento.com` | `coord123` |
| Técnico | `tecnico@sseguimiento.com` | `tecnico123` |

### Pasos para ingresar

1. Abrir el navegador y dirigirse a `http://localhost:8000`
2. Serás redirigido automáticamente a `/login`
3. Ingresar el **correo** y **contraseña**
4. Clic en **Iniciar Sesión**
5. Serás redirigido al **Dashboard**

### Cambiar contraseña

1. En el menú lateral → clic en tu nombre de usuario
2. O ir directamente a `/cambiar-contrasena`
3. Ingresar la contraseña actual y la nueva (dos veces)
4. Clic en **Guardar**

### Cerrar sesión

- Clic en el botón **Salir** (esquina superior derecha del navbar)

---

## 4. Dashboard

El dashboard es la pantalla principal del sistema. Muestra un resumen estadístico y accesos rápidos.

### Estadísticas visibles

| Indicador | Descripción |
|---|---|
| **Emprendimientos** | Total de emprendimientos registrados |
| **Emprendedores** | Total de emprendedores en el sistema |
| **Seguimientos** | Total de seguimientos realizados |
| **Usuarios** | Total de usuarios del sistema |
| **Asesorías** | Total de asesorías registradas |

### Tabla de últimos emprendimientos

Muestra los 5 emprendimientos más recientes con nombre, categoría y estado del proceso. Permite acceso directo a cada uno.

### Acciones rápidas

Botones de acceso directo para las operaciones más frecuentes:
- Nuevo Emprendimiento *(visible para Admin)*
- Nuevo Emprendedor
- Nuevo Seguimiento
- Nueva Asesoría *(visible para Admin y Coordinador)*
- Nuevo Usuario *(visible para Admin)*

---

## 5. Módulo: Emprendimientos

> **Lectura:** todos los roles | **Escritura:** solo Administrador

Un **emprendimiento** es la unidad central del sistema. Representa un negocio o proyecto en proceso de acompañamiento.

### 5.1 Ver lista de emprendimientos

**Ruta:** `/emprendimientos`

Muestra todos los emprendimientos registrados con:
- Nombre del emprendimiento
- Categoría
- Municipio
- Estado del proceso
- Emprendedores asociados

**Filtros disponibles:**
- Búsqueda por nombre (campo de texto)
- Filtro por estado del proceso

### 5.2 Ver detalle de un emprendimiento

**Ruta:** `/emprendimientos/{id}`

Muestra toda la información del emprendimiento organizada en pestañas:
- **Información general:** categoría, municipio, dirección, sector/rubro, estado
- **Emprendedores:** lista de emprendedores asociados con sus datos
- **Productos:** productos o servicios del emprendimiento
- **Proceso de selección:** formularios de inscripción, entrevistas, planes de negocio
- **Seguimientos:** historial de seguimientos realizados
- **Asesorías:** asesorías técnicas realizadas
- **Historial:** registro de cambios del sistema

### 5.3 Crear un nuevo emprendimiento *(solo Admin)*

**Ruta:** `/emprendimientos/create`

El formulario de creación registra simultáneamente el emprendimiento y su **primer emprendedor**:

**Datos del Emprendimiento:**
| Campo | Requerido | Descripción |
|---|:---:|---|
| Nombre | ✅ | Nombre del emprendimiento |
| Categoría | ✅ | Seleccionar de las categorías registradas |
| Municipio | ✅ | Ubicación geográfica |
| Estado del proceso | ❌ | `pendiente`, `activo`, `finalizado`, etc. |
| Dirección | ❌ | Dirección física |
| Sector/Rubro | ❌ | Área de actividad económica |

**Datos del Primer Emprendedor:**
| Campo | Requerido | Descripción |
|---|:---:|---|
| Código | ✅ | Código único del emprendedor |
| Nombre | ✅ | Nombre(s) |
| Apellidos | ✅ | Apellidos |
| CI | ❌ | Cédula de identidad |
| Edad | ❌ | Edad en años |
| Sexo | ❌ | M / F / Otro |
| Celular | ❌ | Número de contacto |
| Correo | ❌ | Correo electrónico |
| Carrera | ❌ | Carrera universitaria |
| Año de estudio | ❌ | Año en curso |

### 5.4 Editar un emprendimiento *(solo Admin)*

**Ruta:** `/emprendimientos/{id}/edit`

Permite modificar los datos generales del emprendimiento (no los emprendedores desde aquí).

### 5.5 Eliminar un emprendimiento *(solo Admin)*

Desde la vista de detalle o lista, botón **Eliminar**.

> ⚠️ **Advertencia:** Eliminar un emprendimiento borrará también todos sus seguimientos, asesorías, formularios, entrevistas y planes de negocio asociados.

### 5.6 Estados del proceso

| Estado | Descripción |
|---|---|
| `pendiente` | Emprendimiento en evaluación inicial |
| `activo` | En seguimiento activo |
| `finalizado` | Proceso de acompañamiento concluido |
| `suspendido` | Temporalmente fuera de seguimiento |

---

## 6. Módulo: Emprendedores

> **Todos los roles pueden gestionar emprendedores**

Un **emprendedor** es la persona vinculada a un emprendimiento. Un emprendimiento puede tener múltiples emprendedores.

### 6.1 Ver lista de emprendedores

**Ruta:** `/emprendedores`

Muestra todos los emprendedores con nombre, apellidos, CI, código y emprendimiento vinculado.

**Filtros:** búsqueda por nombre, apellidos o CI.

### 6.2 Ver detalle de un emprendedor

**Ruta:** `/emprendedores/{id}`

Muestra los datos personales completos y el emprendimiento al que pertenece.

### 6.3 Registrar un nuevo emprendedor

**Ruta:** `/emprendedores/create`

| Campo | Requerido | Descripción |
|---|:---:|---|
| Código | ✅ | Código único (ej: EMP-001) |
| Emprendimiento | ✅ | Seleccionar el emprendimiento al que pertenece |
| Nombre | ✅ | Nombre(s) del emprendedor |
| Apellidos | ✅ | Apellidos |
| Edad | ❌ | Edad |
| Sexo | ❌ | M / F / Otro |
| CI | ❌ | Cédula de identidad |
| Celular | ❌ | Teléfono de contacto |
| Correo | ❌ | Email |
| Dirección | ❌ | Dirección de residencia |
| Carrera | ❌ | Carrera universitaria |
| Año de estudio | ❌ | Año académico actual |

> 💡 También se puede registrar un emprendedor desde la vista de detalle del emprendimiento.

### 6.4 Editar y eliminar

Disponible desde la lista o el detalle del emprendedor para todos los roles.

---

## 7. Módulo: Seguimientos

> **Todos los roles pueden crear y gestionar seguimientos**

Un **seguimiento** es una visita o reunión periódica de acompañamiento a un emprendimiento. Cada seguimiento tiene un número secuencial, una fecha, y puede contener múltiples **compromisos** y **actividades**.

### Estructura de un Seguimiento

```
Seguimiento (número + fecha + emprendimiento)
├── Compromisos (acuerdos tomados)
│   └── Actividades vinculadas al compromiso
└── Actividades libres (no vinculadas a un compromiso)
```

### 7.1 Ver lista de seguimientos

**Ruta:** `/seguimientos-emprendimiento`

Muestra todos los seguimientos con: número, emprendimiento, fecha.

**Filtro:** por emprendimiento específico.

### 7.2 Ver detalle de un seguimiento

**Ruta:** `/seguimientos-emprendimiento/{id}`

Muestra:
- Información del seguimiento (número, fecha, emprendimiento)
- **Lista de Compromisos** con estado y opciones para agregar/eliminar
- **Lista de Actividades** con estado y compromiso de origen (si aplica)

### 7.3 Crear un nuevo seguimiento

**Ruta:** `/seguimientos-emprendimiento/create`

| Campo | Requerido | Descripción |
|---|:---:|---|
| Emprendimiento | ✅ | Seleccionar el emprendimiento |
| Número de seguimiento | ✅ | Número secuencial (1, 2, 3...) |
| Fecha | ✅ | Fecha del seguimiento |

Después de crear el seguimiento, serás redirigido al detalle donde puedes agregar compromisos y actividades.

### 7.4 Agregar un Compromiso al seguimiento

Desde la vista de detalle del seguimiento:

1. En la sección **Compromisos**, clic en **+ Agregar Compromiso**
2. Completar:
   - **Descripción:** texto del compromiso acordado
   - **Estado:** `pendiente`, `en_proceso`, `cumplido`, `incumplido`
3. Clic en **Guardar**

### 7.5 Agregar una Actividad al seguimiento

Desde la vista de detalle del seguimiento:

1. En la sección **Actividades**, clic en **+ Agregar Actividad**
2. Completar:
   - **Descripción:** descripción de la actividad realizada o por realizar
   - **Estado:** estado actual de la actividad
   - **Compromiso origen** *(opcional):* vincular la actividad a un compromiso previo
3. Clic en **Guardar**

### 7.6 Eliminar compromisos y actividades

Desde el detalle del seguimiento, cada compromiso y actividad tiene un botón **Eliminar** (ícono de papelera).

### 7.7 Eliminar un seguimiento

Botón **Eliminar** disponible en la lista o el detalle.

> ⚠️ Eliminar un seguimiento borra también todos sus compromisos y actividades.

---

## 8. Módulo: Asesorías

> **Ver:** todos los roles | **Crear/Editar/Eliminar:** Administrador y Coordinador

Una **asesoría** es una sesión de apoyo técnico o consultoría dirigida a un emprendimiento. Tiene hora de inicio/fin, tipo, temática y puede generar compromisos específicos.

### 8.1 Ver lista de asesorías

**Ruta:** `/asesorias`

Muestra todas las asesorías con: emprendimiento, fecha, tipo, temática.

**Filtro:** por emprendimiento.

### 8.2 Ver detalle de una asesoría

**Ruta:** `/asesorias/{id}`

Muestra:
- Emprendimiento, fecha, hora inicio/fin
- Tipo y temática
- Descripción y observaciones
- Lista de compromisos generados

### 8.3 Registrar una nueva asesoría *(Admin y Coordinador)*

**Ruta:** `/asesorias/create`

| Campo | Requerido | Descripción |
|---|:---:|---|
| Emprendimiento | ✅ | Seleccionar el emprendimiento |
| Fecha | ✅ | Fecha de la asesoría |
| Hora de inicio | ✅ | Hora de inicio (HH:MM) |
| Hora de fin | ✅ | Hora de finalización (HH:MM) |
| Tipo | ✅ | Ej: "Técnica", "Financiera", "Legal", "Marketing" |
| Temática | ✅ | Tema tratado en la asesoría |
| Descripción | ❌ | Descripción detallada del contenido |
| Observaciones | ❌ | Notas adicionales o recomendaciones |

### 8.4 Agregar un compromiso a la asesoría *(Admin y Coordinador)*

Desde el detalle de la asesoría:

1. En la sección **Compromisos**, clic en **+ Agregar Compromiso**
2. Completar:
   - **Actividad:** descripción de la actividad comprometida
   - **Responsable:** nombre del responsable de cumplirla
   - **Fecha:** fecha límite de cumplimiento
   - **Estado:** `pendiente`, `en_proceso`, `cumplido`
3. Clic en **Guardar**

### 8.5 Editar y eliminar asesorías *(Admin y Coordinador)*

Disponible desde el detalle de la asesoría.

---

## 9. Módulo: Administración

> **Solo Administrador**

### 9.1 Gestión de Usuarios

**Ruta:** `/usuarios`

Permite crear, editar y eliminar usuarios del sistema.

**Crear usuario:**

| Campo | Requerido | Descripción |
|---|:---:|---|
| Nombre | ✅ | Nombre completo |
| Correo | ✅ | Email único de acceso |
| Contraseña | ✅ | Contraseña inicial |
| Rol | ✅ | Administrador / Coordinador / Técnico |
| Región | ❌ | Región territorial asignada |
| Municipio | ❌ | Municipio asignado |

### 9.2 Gestión de Categorías de Emprendimiento

**Ruta:** `/categorias/emprendimiento`

Permite crear, editar y eliminar las categorías que se asignan a los emprendimientos.

> ⚠️ No se puede eliminar una categoría que tenga emprendimientos asociados.

**Crear categoría:**
- Solo requiere el **nombre de la categoría**

### 9.3 Gestión de Roles

**Ruta:** `/roles`

Permite ver, crear y eliminar roles del sistema.

> ⚠️ Los roles base (Administrador, Coordinador, Técnico) no deben eliminarse.

### 9.4 Gestión de Regiones

**Ruta:** `/regiones`

Permite registrar las regiones geográficas del sistema.

### 9.5 Gestión de Municipios

**Ruta:** `/municipios`

Permite registrar municipios asociados a una región.

| Campo | Requerido | Descripción |
|---|:---:|---|
| Nombre del municipio | ✅ | Nombre del municipio |
| Región | ✅ | Región a la que pertenece |

---

## 10. API REST

El sistema expone una API REST completa bajo el prefijo `/api`. Requiere autenticación con token **Bearer**.

### Autenticación

```bash
# Iniciar sesión y obtener token
POST /api/auth/login
Content-Type: application/json

{
  "correo": "admin@sseguimiento.com",
  "contraseña": "admin123"
}

# Respuesta:
{
  "token": "1|abc123...",
  "usuario": { ... }
}
```

```bash
# Usar el token en todas las peticiones
Authorization: Bearer 1|abc123...
```

```bash
# Cerrar sesión
POST /api/auth/logout
Authorization: Bearer {token}
```

### Endpoints disponibles

#### Autenticación
| Método | Endpoint | Descripción |
|---|---|---|
| POST | `/api/auth/register` | Registrar usuario |
| POST | `/api/auth/login` | Iniciar sesión |
| GET | `/api/auth/me` | Ver perfil propio |
| POST | `/api/auth/logout` | Cerrar sesión |
| POST | `/api/auth/change-password` | Cambiar contraseña |

#### Territorial
| Método | Endpoint | Descripción |
|---|---|---|
| GET/POST | `/api/roles` | Listar / Crear roles |
| GET/PUT/DELETE | `/api/roles/{id}` | Ver / Editar / Eliminar rol |
| GET/POST | `/api/regiones` | Listar / Crear regiones |
| GET/POST | `/api/municipios` | Listar / Crear municipios |
| GET/POST | `/api/usuarios` | Listar / Crear usuarios |

#### Emprendimientos
| Método | Endpoint | Descripción |
|---|---|---|
| GET/POST | `/api/categorias-emprendimiento` | Listar / Crear categorías |
| GET/POST | `/api/emprendimientos` | Listar / Crear emprendimientos |
| GET | `/api/emprendimientos/{id}/seguimientos` | Seguimientos de un emprendimiento |
| GET | `/api/emprendimientos/{id}/asesorias` | Asesorías de un emprendimiento |
| GET | `/api/emprendimientos/{id}/productos` | Productos de un emprendimiento |
| GET | `/api/emprendimientos/{id}/historial` | Historial de un emprendimiento |
| GET/POST | `/api/emprendedores` | Listar / Crear emprendedores |
| POST | `/api/emprendedores/{id}/asociar-emprendimiento` | Asociar a emprendimiento |
| GET/POST | `/api/productos` | Listar / Crear productos |

#### Selección
| Método | Endpoint | Descripción |
|---|---|---|
| GET/POST | `/api/formularios-inscripcion` | Formularios |
| GET/POST | `/api/entrevistas` | Entrevistas |
| GET/POST | `/api/planes-negocio` | Planes de negocio |

#### Seguimiento
| Método | Endpoint | Descripción |
|---|---|---|
| GET/POST | `/api/seguimientos-emprendimiento` | Listar / Crear seguimientos |
| GET | `/api/seguimientos-emprendimiento/{id}/compromisos` | Compromisos del seguimiento |
| GET | `/api/seguimientos-emprendimiento/{id}/actividades` | Actividades del seguimiento |
| GET/POST | `/api/compromisos-emprendimiento` | Compromisos |
| GET/POST | `/api/actividades-emprendimiento` | Actividades |
| GET/POST | `/api/historial-emprendimiento` | Historial |

#### Asesorías
| Método | Endpoint | Descripción |
|---|---|---|
| GET/POST | `/api/asesorias` | Listar / Crear asesorías |
| GET | `/api/asesorias/{id}/compromisos` | Compromisos de la asesoría |
| GET/POST | `/api/compromisos-asesoria` | Compromisos de asesoría |

### Ejemplo completo de uso de la API

```bash
# 1. Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"correo":"admin@sseguimiento.com","contraseña":"admin123"}'

# 2. Listar emprendimientos
curl http://localhost:8000/api/emprendimientos \
  -H "Authorization: Bearer {token}"

# 3. Crear seguimiento
curl -X POST http://localhost:8000/api/seguimientos-emprendimiento \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"id_emprendimiento":1,"numero_seguimiento":1,"fecha":"2026-04-01"}'
```

---

## 11. Flujo de Trabajo Recomendado

### Para un nuevo emprendimiento

```
1. [Admin] Crear la categoría si no existe
         → /categorias/emprendimiento

2. [Admin] Registrar el municipio si no existe
         → /municipios

3. [Admin] Crear el emprendimiento con su primer emprendedor
         → /emprendimientos/create

4. [Todos] Agregar más emprendedores si hay varios
         → /emprendedores/create

5. [Coordinador/Admin] Registrar formulario de inscripción
         → Desde el detalle del emprendimiento

6. [Coordinador/Admin] Registrar entrevista
         → Desde el detalle del emprendimiento

7. [Coordinador/Admin] Registrar plan de negocio
         → Desde el detalle del emprendimiento

8. [Admin] Cambiar estado a "activo"
         → /emprendimientos/{id}/edit

9. [Todos] Registrar seguimientos periódicos
         → /seguimientos-emprendimiento/create

10. [Coordinador/Admin] Registrar asesorías de apoyo
          → /asesorias/create
```

### Para un seguimiento periódico

```
1. Ir a → /seguimientos-emprendimiento/create
2. Seleccionar el emprendimiento
3. Ingresar el número de seguimiento (secuencial)
4. Ingresar la fecha del seguimiento
5. En el detalle: agregar compromisos acordados en la reunión
6. En el detalle: agregar actividades realizadas o asignadas
7. Vincular actividades a compromisos si corresponde
```

---

## 12. Preguntas Frecuentes

**¿Puedo tener varios emprendedores en un mismo emprendimiento?**
Sí. Desde el detalle del emprendimiento puedes agregar más emprendedores, o desde `/emprendedores/create` seleccionando el emprendimiento correspondiente.

**¿Qué pasa si creo un seguimiento con el mismo número para el mismo emprendimiento?**
El sistema lo permite. Se recomienda mantener la numeración secuencial y única por emprendimiento para facilitar la trazabilidad.

**¿Puedo filtrar los seguimientos por emprendimiento?**
Sí, en `/seguimientos-emprendimiento` hay un filtro por emprendimiento.

**¿Quién puede ver el historial de cambios?**
Todos los roles pueden ver el historial. Se muestra en el detalle de cada emprendimiento.

**¿Cómo cambio el estado de un compromiso a "cumplido"?**
Actualmente los estados se asignan manualmente al crear o editar el compromiso. Para actualizar el estado de un compromiso existente, se debe usar la API `PUT /api/compromisos-emprendimiento/{id}`.

**¿Puedo usar el sistema sin conexión a internet?**
El sistema corre localmente, por lo que no necesitas internet para acceder. Solo necesitas que el servidor Laravel esté corriendo.

**¿Cuál es la diferencia entre una Actividad y un Compromiso en un seguimiento?**
- **Compromiso:** un acuerdo tomado en la reunión de seguimiento que el emprendedor o su equipo debe cumplir antes del próximo seguimiento.
- **Actividad:** una acción concreta realizada o asignada, que puede estar vinculada a un compromiso previo o ser independiente.

---

*Última actualización: Abril 2026 — SSISTEMALED_EMP v1.0*
