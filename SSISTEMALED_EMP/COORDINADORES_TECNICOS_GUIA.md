# Sistema de Seguimiento LED
## Para Coordinadores y Técnicos

### 🎯 Propósito
Sistema de supervisión y seguimiento de emprendimientos LED para coordinadores y técnicos que necesitan:
- Registrar y supervisar emprendimientos
- Realizar seguimientos periódicos
- Gestionar compromisos y actividades
- Administrar unidades productivas
- Documentar compras y ventas

---

## 👥 Roles del Sistema

### Administrador
- Acceso total al sistema
- Gestión de usuarios y coordinadores
- Reportes globales
- Configuración del sistema

### Coordinador
- Supervisión de emprendimientos por territorio
- Gestión de seguimientos
- Asignación de técnicos
- Reportes territoriales

### Técnico
- Ejecución de seguimientos
- Documentación de actividades
- Registro de compromisos
- Datos de unidades productivas

---

## 🚀 Inicio Rápido

### 1. Iniciar Servidor
```bash
cd c:\Users\LENOVO\Desktop\SistemaSeguimiento\sseguimientoLED
php artisan serve
```

### 2. Login
```bash
# Coordinador
Correo: coordinador@sseguimiento.com
Contraseña: coord123

# Técnico
Correo: tecnico@sseguimiento.com
Contraseña: tecnico123
```

### 3. Obtener Token
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "correo": "coordinador@sseguimiento.com",
    "contraseña": "coord123"
  }'
```

### 4. Usar el Token en Solicitudes
```bash
curl -X GET http://localhost:8000/api/emprendimientos \
  -H "Authorization: Bearer {token_recibido_del_login}"
```

---

## 📊 Datos Disponibles en Sistema

### Territorios
- **La Paz**: 2 municipios (La Paz, El Alto)
- **Cochabamba**: 1 municipio (Cochabamba)
- **Santa Cruz**: 1 municipio (Santa Cruz)

### Unidades Productivas
- **Laboratorio de Alimentos ITB** (La Paz)
- **Taller de Textiles UMSS** (Cochabamba)

### Emprendimientos
*(Supervisados por coordinadores y técnicos)*
- Panadería Artesanal del Valle
- Tejidos Andinos Cochabamba

---

## 📚 Endpoints Principales

### Emprendimientos
- `GET /api/emprendimientos` - Listar todos
- `POST /api/emprendimientos` - Crear nuevo
- `GET /api/emprendimientos/{id}` - Detalles
- `PUT /api/emprendimientos/{id}` - Actualizar
- `DELETE /api/emprendimientos/{id}` - Eliminar
- `GET /api/emprendimientos/{id}/seguimientos` - Ver seguimientos

### Unidades Productivas
- `GET /api/unidades-productivas` - Listar
- `POST /api/unidades-productivas` - Crear
- `GET /api/unidades-productivas/{id}` - Detalles
- `GET /api/unidades-productivas/{id}/seguimientos` - Seguimientos

### Seguimientos
- `GET /api/seguimientos-emprendimiento` - Listar seguimientos
- `POST /api/seguimientos-emprendimiento` - Crear seguimiento
- `GET /api/seguimientos-emprendimiento/{id}/compromisos` - Compromisos
- `GET /api/seguimientos-emprendimiento/{id}/actividades` - Actividades

### Usuarios
- `GET /api/usuarios` - Listar usuarios
- `POST /api/usuarios` - Crear usuario
- `GET /api/usuarios/{id}` - Detalles usuario

---

## 🔐 Autenticación

### Register (Nuevo Usuario)
```bash
POST /api/auth/register
{
  "nombre": "Nuevo Coordinador",
  "correo": "nuevo@sseguimiento.com",
  "contraseña": "password123",
  "contraseña_confirmation": "password123",
  "rol_id": 2,  // 2 = Coordinador
  "region_id": 1,
  "municipio_id": 1
}
```

### Login
```bash
POST /api/auth/login
{
  "correo": "coordinador@sseguimiento.com",
  "contraseña": "coord123"
}
```

### Logout
```bash
POST /api/auth/logout
Headers: Authorization: Bearer {token}
```

### Cambiar Contraseña
```bash
POST /api/auth/change-password
Headers: Authorization: Bearer {token}
{
  "contraseña_actual": "old123",
  "contraseña_nueva": "new123",
  "contraseña_nueva_confirmation": "new123"
}
```

---

## 💾 Base de Datos

**Tipo:** MySQL 5.7+  
**Host:** 127.0.0.1  
**Puerto:** 3306  
**Base de datos:** bd_led  

**Tablas principales:**
- usuarios
- rols
- emprendimientos
- unidades_productivas
- seguimientos_emprendimiento
- seguimientos_unidad
- compromisos_emprendimiento
- actividades_emprendimiento
- compras
- ventas

---

## 📖 Documentación Completa

- **AUTH_DOCUMENTATION.md** - Guía de autenticación con ejemplos detallados
- **API_DOCUMENTATION.md** - Especificación completa de endpoints
- **PROJECT_STATUS.md** - Estado técnico del proyecto

---

## ⚙️ Configuración (.env)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bd_led
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🆘 Soporte

### Comando útiles
```bash
# Limpiar y repoblar BD
php artisan migrate:fresh --seed

# Ver todas las rutas
php artisan route:list

# Acceder a BD interactivamente
php artisan tinker

# Ejecutar tests
php artisan test --filter=AuthenticationTest
```

### Logs
```
storage/logs/laravel.log
```

---

## ✨ Estado del Proyecto

✅ **Completo y Operativo**
- Sistema de autenticación funcional
- 70+ endpoints API
- Base de datos con datos de prueba
- Documentación completa
- Pruebas automatizadas

📦 **Listo para:**
- Integración con frontend
- Desarrollo de funcionalidades adicionales
- Despliegue en producción

---

**Versión:** 1.0.0  
**Última actualización:** Marzo 2025
