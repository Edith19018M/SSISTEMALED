# SSISTEMALED_UPS — Guía de Uso Completa
## Sistema de Seguimiento de Unidades Productivas

> **Versión:** 1.0 | **URL:** http://localhost:8001 | **Base de datos:** `ssistemaled_ups`

---

## Tabla de Contenidos

1. [Descripción General](#1-descripción-general)
2. [Roles y Permisos](#2-roles-y-permisos)
3. [Acceso al Sistema](#3-acceso-al-sistema)
4. [Dashboard](#4-dashboard)
5. [Módulo: Unidades Productivas](#5-módulo-unidades-productivas)
6. [Módulo: Responsables](#6-módulo-responsables)
7. [Módulo: Seguimientos](#7-módulo-seguimientos)
8. [Módulo: Compras y Ventas](#8-módulo-compras-y-ventas)
9. [Módulo: Administración](#9-módulo-administración)
10. [API REST](#10-api-rest)
11. [Flujo de Trabajo Recomendado](#11-flujo-de-trabajo-recomendado)
12. [Preguntas Frecuentes](#12-preguntas-frecuentes)

---

## 1. Descripción General

**SSISTEMALED_UPS** es el sistema de seguimiento diseñado exclusivamente para la gestión de **unidades productivas**. Permite registrar unidades productivas (laboratorios, talleres, centros de producción), asignarles responsables, llevar seguimientos periódicos de su actividad, y registrar sus operaciones comerciales (compras y ventas).

### Qué permite hacer este sistema

- Registrar y gestionar unidades productivas con su información completa
- Asignar responsables a cada unidad (con fecha de inicio y fin de cargo)
- Llevar seguimientos periódicos con compromisos y actividades
- Registrar el historial completo de cambios
- Gestionar compras y ventas de cada unidad productiva
- Gestionar usuarios, roles y territorio (regiones/municipios)

---

## 2. Roles y Permisos

El sistema tiene **3 roles** con diferentes niveles de acceso:

### Tabla de Permisos

| Módulo / Acción | Administrador | Coordinador | Técnico |
|---|:---:|:---:|:---:|
| **Dashboard** — Ver | ✅ | ✅ | ✅ |
| **Unidades Productivas** — Ver/Listar | ✅ | ✅ | ✅ |
| **Unidades Productivas** — Crear / Editar / Eliminar | ✅ | ❌ | ❌ |
| **Unidades Productivas** — Asociar Responsable | ✅ | ✅ | ✅ |
| **Responsables** — Ver/Listar | ✅ | ✅ | ✅ |
| **Responsables** — Crear / Editar / Eliminar | ✅ | ✅ | ✅ |
| **Seguimientos** — Ver/Listar | ✅ | ✅ | ✅ |
| **Seguimientos** — Crear / Gestionar compromisos y actividades | ✅ | ✅ | ✅ |
| **Seguimientos** — Eliminar | ✅ | ✅ | ✅ |
| **Compras** — Ver/Registrar/Eliminar | ✅ | ✅ | ✅ |
| **Ventas** — Ver/Registrar/Eliminar | ✅ | ✅ | ✅ |
| **Usuarios** — Gestionar | ✅ | ❌ | ❌ |
| **Categorías** — Gestionar | ✅ | ❌ | ❌ |
| **Territoriales** (Roles, Regiones, Municipios) | ✅ | ❌ | ❌ |

### Descripción de cada Rol

#### Administrador
Control total del sistema. Puede crear, editar y eliminar cualquier registro. Gestiona usuarios, roles, regiones, municipios y categorías. Es el único que puede crear o modificar unidades productivas.

#### Coordinador
Perfil operativo intermedio. Puede gestionar toda la actividad de seguimiento, registrar compras y ventas, y administrar responsables. No puede crear ni modificar unidades productivas directamente, ni administrar usuarios o configuraciones del sistema.

#### Técnico
Perfil de campo. Puede registrar seguimientos, compromisos, actividades, compras, ventas y responsables. Puede consultar toda la información del sistema. No puede crear ni modificar unidades productivas ni configuraciones.

---

## 3. Acceso al Sistema

### Credenciales de Prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | `admin@sseguimiento.com` | `admin123` |
| Coordinador | `coordinador@sseguimiento.com` | `coord123` |
| Técnico | `tecnico@sseguimiento.com` | `tecnico123` |

### Pasos para ingresar

1. Abrir el navegador y dirigirse a `http://localhost:8001`
2. Serás redirigido automáticamente a `/login`
3. Ingresar el **correo** y **contraseña**
4. Clic en **Iniciar Sesión**
5. Serás redirigido al **Dashboard**

### Cambiar contraseña

1. Ir a `/cambiar-contrasena`
2. Ingresar la contraseña actual y la nueva (dos veces)
3. Clic en **Guardar**

### Cerrar sesión

- Clic en el botón **Salir** (esquina superior derecha del navbar)

---

## 4. Dashboard

El dashboard muestra el estado general del sistema con estadísticas e indicadores clave.

### Estadísticas visibles

| Indicador | Descripción |
|---|---|
| **Unidades Productivas** | Total de unidades registradas |
| **Responsables** | Total de responsables registrados |
| **Seguimientos** | Total de seguimientos realizados |
| **Usuarios** | Total de usuarios del sistema |
| **Compras** | Total de registros de compras |
| **Ventas** | Total de registros de ventas |

### Tabla de últimas unidades productivas

Muestra las 5 unidades más recientes con nombre, categoría y municipio. Permite acceso directo a cada una.

### Acciones rápidas

Botones de acceso directo para las operaciones más frecuentes:
- Nueva Unidad Productiva *(visible para Admin)*
- Nuevo Responsable
- Nuevo Seguimiento
- Nueva Compra
- Nueva Venta
- Nuevo Usuario *(visible para Admin)*

---

## 5. Módulo: Unidades Productivas

> **Lectura:** todos los roles | **Escritura:** solo Administrador

Una **unidad productiva** es una instalación, laboratorio, taller o centro de producción que opera dentro de una institución educativa o productiva y recibe acompañamiento del sistema.

### 5.1 Ver lista de unidades productivas

**Ruta:** `/unidades`

Muestra todas las unidades registradas con:
- Nombre
- Categoría
- Municipio
- Responsables asignados

**Filtro disponible:** búsqueda por nombre.

### 5.2 Ver detalle de una unidad productiva

**Ruta:** `/unidades/{id}`

Muestra toda la información organizada en secciones:
- **Información general:** categoría, municipio, dirección
- **Responsables:** lista de responsables asignados con fechas de vigencia
- **Seguimientos:** historial de seguimientos realizados
- **Compras:** registros de compras de la unidad
- **Ventas:** registros de ventas de la unidad
- **Historial:** registro de cambios del sistema

### 5.3 Crear una nueva unidad productiva *(solo Admin)*

**Ruta:** `/unidades/create`

| Campo | Requerido | Descripción |
|---|:---:|---|
| Nombre | ✅ | Nombre de la unidad productiva |
| Categoría | ✅ | Seleccionar de las categorías registradas |
| Municipio | ✅ | Ubicación geográfica |
| Dirección | ❌ | Dirección física de la unidad |

### 5.4 Asociar un Responsable a la unidad

Desde la vista de detalle de la unidad:

1. En la sección **Responsables**, clic en **+ Asociar Responsable**
2. Completar:
   - **Responsable:** seleccionar de la lista
   - **Fecha de inicio:** fecha en que asume el cargo
   - **Fecha de fin** *(opcional):* dejar en blanco si aún está activo
3. Clic en **Guardar**

> 💡 Una misma unidad puede tener múltiples responsables activos simultáneamente. Un mismo responsable puede estar asignado a varias unidades.

### 5.5 Editar una unidad productiva *(solo Admin)*

**Ruta:** `/unidades/{id}/edit`

Permite modificar los datos generales de la unidad.

### 5.6 Eliminar una unidad productiva *(solo Admin)*

Botón **Eliminar** disponible en la lista o el detalle.

> ⚠️ **Advertencia:** Eliminar una unidad borrará también todos sus seguimientos, compras, ventas e historial asociados.

---

## 6. Módulo: Responsables

> **Todos los roles pueden gestionar responsables**

Un **responsable** es la persona encargada de una unidad productiva. Puede estar asignado a una o varias unidades, con fechas de inicio y fin de cargo.

### 6.1 Ver lista de responsables

**Ruta:** `/responsables`

Muestra todos los responsables registrados con nombre, cargo, teléfono y correo.

### 6.2 Ver detalle de un responsable

**Ruta:** `/responsables/{id}`

Muestra los datos del responsable y las unidades a las que está o estuvo asignado.

### 6.3 Registrar un nuevo responsable

**Ruta:** `/responsables/create`

| Campo | Requerido | Descripción |
|---|:---:|---|
| Nombre | ✅ | Nombre completo del responsable |
| CI | ❌ | Cédula de identidad |
| Contacto | ❌ | Teléfono o celular |
| Correo | ❌ | Correo electrónico institucional |

> 💡 Después de crear el responsable, ve al detalle de la unidad productiva para asociarlo.

### 6.4 Editar y eliminar responsables

Disponible desde la lista o el detalle del responsable para todos los roles.

---

## 7. Módulo: Seguimientos

> **Todos los roles pueden crear y gestionar seguimientos**

Un **seguimiento** es una visita o reunión periódica de monitoreo a una unidad productiva. Cada seguimiento tiene un número secuencial, una fecha, y puede contener múltiples **compromisos** y **actividades**.

### Estructura de un Seguimiento

```
Seguimiento (número + fecha + unidad productiva)
├── Compromisos (acuerdos tomados)
│   └── Actividades vinculadas al compromiso
└── Actividades libres (no vinculadas a un compromiso)
```

### 7.1 Ver lista de seguimientos

**Ruta:** `/seguimientos-unidad`

Muestra todos los seguimientos con: número, unidad productiva, fecha.

**Filtro:** por unidad productiva específica.

### 7.2 Ver detalle de un seguimiento

**Ruta:** `/seguimientos-unidad/{id}`

Muestra:
- Información del seguimiento (número, fecha, unidad)
- **Lista de Compromisos** con estado y opciones para agregar/eliminar
- **Lista de Actividades** con estado y compromiso de origen (si aplica)

### 7.3 Crear un nuevo seguimiento

**Ruta:** `/seguimientos-unidad/create`

| Campo | Requerido | Descripción |
|---|:---:|---|
| Unidad Productiva | ✅ | Seleccionar la unidad a seguir |
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

Desde el detalle del seguimiento, cada compromiso y actividad tiene un botón **Eliminar**.

### 7.7 Eliminar un seguimiento

Botón **Eliminar** disponible en la lista o el detalle.

> ⚠️ Eliminar un seguimiento borra también todos sus compromisos y actividades.

---

## 8. Módulo: Compras y Ventas

> **Todos los roles pueden registrar y ver compras y ventas**

El módulo de **Compras y Ventas** registra las operaciones comerciales de cada unidad productiva, permitiendo tener un registro histórico de insumos adquiridos y productos vendidos.

### 8.1 Módulo Compras

#### Ver lista de compras

**Ruta:** `/compras`

Muestra todas las compras registradas con: unidad productiva, producto, cantidad, precio unitario, proveedor, fecha.

#### Registrar una nueva compra

**Ruta:** `/compras/create`

| Campo | Requerido | Descripción |
|---|:---:|---|
| Unidad Productiva | ✅ | Unidad que realiza la compra |
| Producto | ✅ | Nombre del producto o insumo adquirido |
| Cantidad | ✅ | Cantidad adquirida |
| Precio unitario | ✅ | Precio por unidad (en Bs.) |
| Fecha | ✅ | Fecha de la compra |
| Proveedor | ❌ | Nombre o razón social del proveedor |

#### Eliminar una compra

Botón **Eliminar** disponible en la lista de compras.

---

### 8.2 Módulo Ventas

#### Ver lista de ventas

**Ruta:** `/ventas`

Muestra todas las ventas registradas con: unidad productiva, producto, cantidad, precio unitario, cliente, fecha.

#### Registrar una nueva venta

**Ruta:** `/ventas/create`

| Campo | Requerido | Descripción |
|---|:---:|---|
| Unidad Productiva | ✅ | Unidad que realiza la venta |
| Producto | ✅ | Nombre del producto o servicio vendido |
| Cantidad | ✅ | Cantidad vendida |
| Precio unitario | ✅ | Precio por unidad (en Bs.) |
| Fecha | ✅ | Fecha de la venta |
| Cliente | ❌ | Nombre o razón social del cliente |

#### Eliminar una venta

Botón **Eliminar** disponible en la lista de ventas.

---

### 8.3 Ver compras y ventas por unidad

Desde el detalle de una unidad productiva (`/unidades/{id}`), en las secciones **Compras** y **Ventas** se muestran todos los registros correspondientes a esa unidad específica.

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

### 9.2 Gestión de Categorías de Unidades Productivas

**Ruta:** `/categorias/unidad`

Permite crear, editar y eliminar las categorías asignadas a las unidades productivas.

> ⚠️ No se puede eliminar una categoría que tenga unidades productivas asociadas.

**Crear categoría:**

| Campo | Requerido | Descripción |
|---|:---:|---|
| Nombre de la categoría | ✅ | Ej: "Producción de Alimentos" |
| Carrera asociada | ❌ | Carrera universitaria relacionada |

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

#### Unidades Productivas
| Método | Endpoint | Descripción |
|---|---|---|
| GET/POST | `/api/categorias-unidad` | Listar / Crear categorías |
| GET | `/api/categorias-unidad/{id}/unidades` | Unidades de una categoría |
| GET/POST | `/api/unidades-productivas` | Listar / Crear unidades |
| GET | `/api/unidades-productivas/{id}/seguimientos` | Seguimientos de la unidad |
| GET | `/api/unidades-productivas/{id}/compras` | Compras de la unidad |
| GET | `/api/unidades-productivas/{id}/ventas` | Ventas de la unidad |
| GET | `/api/unidades-productivas/{id}/historial` | Historial de la unidad |
| POST | `/api/unidades-productivas/{id}/asociar-responsable` | Asignar responsable |
| GET/POST | `/api/responsables` | Listar / Crear responsables |
| GET | `/api/responsables/{id}/unidades` | Unidades del responsable |

#### Seguimiento
| Método | Endpoint | Descripción |
|---|---|---|
| GET/POST | `/api/seguimientos-unidad` | Listar / Crear seguimientos |
| GET | `/api/seguimientos-unidad/{id}/compromisos` | Compromisos del seguimiento |
| GET | `/api/seguimientos-unidad/{id}/actividades` | Actividades del seguimiento |
| GET/POST | `/api/compromisos-unidad` | Compromisos |
| GET/POST | `/api/actividades-unidad` | Actividades |
| GET/POST | `/api/historial-unidad` | Historial |

#### Compras y Ventas
| Método | Endpoint | Descripción |
|---|---|---|
| GET/POST | `/api/compras` | Listar / Crear compras |
| GET | `/api/unidades-productivas/{id}/compras-list` | Compras de una unidad |
| GET/POST | `/api/ventas` | Listar / Crear ventas |
| GET | `/api/unidades-productivas/{id}/ventas-list` | Ventas de una unidad |

### Ejemplo completo de uso de la API

```bash
# 1. Login
curl -X POST http://localhost:8001/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"correo":"admin@sseguimiento.com","contraseña":"admin123"}'

# 2. Listar unidades productivas
curl http://localhost:8001/api/unidades-productivas \
  -H "Authorization: Bearer {token}"

# 3. Registrar una compra
curl -X POST http://localhost:8001/api/compras \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "id_unidad": 1,
    "producto": "Harina de trigo",
    "cantidad": 50,
    "precio_unitario": 8.50,
    "fecha": "2026-04-01",
    "proveedor": "Distribuidora La Paz"
  }'

# 4. Crear seguimiento
curl -X POST http://localhost:8001/api/seguimientos-unidad \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"id_unidad":1,"numero_seguimiento":1,"fecha":"2026-04-01"}'
```

---

## 11. Flujo de Trabajo Recomendado

### Para registrar una nueva unidad productiva

```
1. [Admin] Crear la categoría si no existe
         → /categorias/unidad

2. [Admin] Registrar el municipio si no existe
         → /municipios

3. [Admin] Crear la unidad productiva
         → /unidades/create

4. [Todos] Registrar al responsable si no existe
         → /responsables/create

5. [Todos] Asociar el responsable a la unidad
         → Desde el detalle de la unidad: /unidades/{id}
         → Sección "Responsables" → Asociar Responsable
         → Ingresar fecha de inicio de cargo

6. [Todos] Registrar el primer seguimiento
         → /seguimientos-unidad/create
```

### Para un seguimiento periódico

```
1. Ir a → /seguimientos-unidad/create
2. Seleccionar la unidad productiva
3. Ingresar el número de seguimiento (secuencial)
4. Ingresar la fecha del seguimiento
5. En el detalle: agregar compromisos acordados en la reunión
6. En el detalle: agregar actividades realizadas o asignadas
7. Vincular actividades a compromisos si corresponde
```

### Para registrar actividad comercial

```
# Registrar una compra de insumos:
1. Ir a → /compras/create
2. Seleccionar la unidad productiva
3. Ingresar el producto, cantidad, precio unitario y fecha
4. Agregar el proveedor si se conoce
5. Guardar

# Registrar una venta:
1. Ir a → /ventas/create
2. Seleccionar la unidad productiva
3. Ingresar el producto vendido, cantidad, precio y fecha
4. Agregar el cliente si se conoce
5. Guardar
```

### Para cambiar de responsable en una unidad

```
1. Ir al detalle de la unidad → /unidades/{id}
2. En la sección "Responsables", el responsable anterior
   tiene fecha_fin vacía (aún activo)
3. Para registrar la salida del responsable anterior,
   usar la API: PUT /api/responsables-unidad/{pivot_id}
   con fecha_fin = fecha de salida
4. Asociar el nuevo responsable con la nueva fecha_inicio
```

---

## 12. Preguntas Frecuentes

**¿Puede una unidad productiva tener más de un responsable activo al mismo tiempo?**
Sí. El sistema permite asignar múltiples responsables simultáneamente (ej: un director y un técnico). Cada asignación tiene su propia fecha de inicio y fin.

**¿Cómo sé qué responsables están activos actualmente?**
En el detalle de la unidad, los responsables con **fecha de fin vacía** son los que están activos actualmente.

**¿Puedo registrar compras y ventas sin importar el rol?**
Sí. Los tres roles (Administrador, Coordinador y Técnico) pueden registrar compras y ventas.

**¿Qué pasa si creo un seguimiento con el mismo número para la misma unidad?**
El sistema lo permite. Se recomienda mantener la numeración secuencial y única por unidad para facilitar la trazabilidad.

**¿Puedo filtrar los seguimientos por unidad productiva?**
Sí, en `/seguimientos-unidad` hay un filtro por unidad productiva.

**¿Cuál es la diferencia entre una Actividad y un Compromiso en un seguimiento?**
- **Compromiso:** un acuerdo tomado en la reunión de seguimiento que la unidad debe cumplir antes del próximo seguimiento.
- **Actividad:** una acción concreta realizada o asignada, que puede estar vinculada a un compromiso previo o ser independiente.

**¿Cómo veo el historial de cambios de una unidad?**
En el detalle de la unidad (`/unidades/{id}`), sección **Historial**, se muestran todos los cambios registrados por el sistema automáticamente.

**¿Puedo registrar el precio de venta con decimales?**
Sí. El campo precio unitario acepta valores decimales (ej: 8.50, 125.75).

**¿Puedo usar el sistema sin conexión a internet?**
El sistema corre localmente, por lo que no necesitas internet para acceder. Solo necesitas que el servidor Laravel esté corriendo.

---

*Última actualización: Abril 2026 — SSISTEMALED_UPS v1.0*
