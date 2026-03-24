# Sistema de Autenticación - API de Seguimiento LED
## Para Coordinadores y Técnicos

### Descripción General

Sistema de autenticación basado en **Laravel Sanctum** para coordinadores y técnicos que supervisan emprendimientos LED. Utiliza tokens de API seguros (Bearer tokens) en el header `Authorization`.

### Usuarios de Prueba

| Usuario | Correo | Contraseña | Rol |
|---------|--------|-----------|-----|
| Admin Sistema | admin@sseguimiento.com | admin123 | Administrador |
| Carlos Coordinador | coordinador@sseguimiento.com | coord123 | Coordinador |
| Ana Técnica | tecnico@sseguimiento.com | tecnico123 | Técnico |

## Endpoints de Autenticación

### 1. Registro de Nuevo Usuario

**POST** `/api/auth/register`

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Juan Pérez",
    "correo": "juan@example.com",
    "contraseña": "password123",
    "contraseña_confirmation": "password123",
    "rol_id": 3,
    "region_id": 1,
    "municipio_id": 1
  }'
```

**Respuesta exitosa (201):**
```json
{
  "success": true,
  "message": "Usuario registrado exitosamente",
  "usuario": {
    "id_usuario": 4,
    "nombre": "Juan Pérez",
    "correo": "juan@example.com",
    "rol_id": 3,
    "region_id": 1,
    "municipio_id": 1,
    "rol": {
      "id_rol": 3,
      "nombre_rol": "Emprendedor"
    },
    "region": {
      "id_region": 1,
      "nombre_region": "La Paz"
    },
    "municipio": {
      "id_municipio": 1,
      "nombre_municipio": "La Paz"
    }
  },
  "token": "1|abcdefghijklmnopqrstuvwxyz123456789"
}
```

### 2. Iniciar Sesión (Login)

**POST** `/api/auth/login`

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "correo": "coordinador@sseguimiento.com",
    "contraseña": "coord123"
  }'
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "message": "Sesión iniciada correctamente",
  "usuario": {
    "id_usuario": 1,
    "nombre": "Admin Sistema",
    "correo": "admin@sseguimiento.com",
    "rol_id": 1,
    "region_id": 1,
    "municipio_id": 1,
    "rol": {
      "id_rol": 1,
      "nombre_rol": "Administrador"
    },
    "region": {
      "id_region": 1,
      "nombre_region": "La Paz"
    },
    "municipio": {
      "id_municipio": 1,
      "nombre_municipio": "La Paz"
    }
  },
  "token": "2|xyz789abcdefghijklmnopqrstuvwxyz123456"
}
```

**Errores posibles:**
- **401**: Credenciales inválidas
- **422**: Validación fallida (campos requeridos)

### 3. Obtener Datos del Usuario Autenticado

**GET** `/api/auth/me`

Requiere autenticación (token en header)

```bash
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer 2|xyz789abcdefghijklmnopqrstuvwxyz123456"
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "usuario": {
    "id_usuario": 1,
    "nombre": "Admin Sistema",
    "correo": "admin@sseguimiento.com",
    "rol_id": 1,
    "region_id": 1,
    "municipio_id": 1,
    "created_at": "2025-01-15T10:30:00.000000Z",
    "updated_at": "2025-01-15T10:30:00.000000Z",
    "rol": {...},
    "region": {...},
    "municipio": {...}
  }
}
```

### 4. Cambiar Contraseña

**POST** `/api/auth/change-password`

Requiere autenticación

```bash
curl -X POST http://localhost:8000/api/auth/change-password \
  -H "Authorization: Bearer 2|xyz789abcdefghijklmnopqrstuvwxyz123456" \
  -H "Content-Type: application/json" \
  -d '{
    "contraseña_actual": "admin123",
    "contraseña_nueva": "newpassword456",
    "contraseña_nueva_confirmation": "newpassword456"
  }'
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "message": "Contraseña cambiada exitosamente"
}
```

### 5. Cerrar Sesión (Logout)

**POST** `/api/auth/logout`

Requiere autenticación

```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer 2|xyz789abcdefghijklmnopqrstuvwxyz123456"
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "message": "Sesión cerrada exitosamente"
}
```

## Usuarios de Prueba

| Nombre | Correo | Contraseña | Rol |
|--------|--------|-----------|-----|
| Admin Sistema | admin@sseguimiento.com | admin123 | Administrador |
| Carlos Coordinador | coordinador@sseguimiento.com | coord123 | Coordinador |
| Ana Técnica | tecnico@sseguimiento.com | tecnico123 | Técnico |

## Manejo de Tokens

### Envío del Token

Todos los endpoints protegidos requieren el token en el header:

```
Authorization: Bearer {token}
```

### Renovación de Tokens

Al iniciar sesión, se revocan todos los tokens anteriores del usuario. Esto garantiza una sesión única activa.

### Tokens Expirados

Si el token está vencido o es inválido:

```json
{
  "message": "Unauthenticated."
}
```

## Ciclo de Vida de Autenticación

1. **Registro o Login** → Obtener token
2. **Usar token** → Incluir en header `Authorization: Bearer {token}`
3. **Operaciones** → Acceder a recursos protegidos
4. **Logout** → Revocar token y terminar sesión

## Seguridad

- Las contraseñas se guardan con hash (bcrypt)
- Los tokens se revogan automáticamente al logout
- Al reloguear, todos los tokens anteriores se revocan
- Las contraseñas nunca se devuelven en las respuestas API

## Próximos Pasos

Con la autenticación implementada, puede:
- ✅ Crear y proteger rutas de API
- ✅ Identificar usuarios en cada solicitud
- ✅ Implementar roles y permisos
- ⏳ Crear pruebas unitarias
- ⏳ Implementar refresh tokens (opcional)
