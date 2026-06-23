# Sistema de Gestión de Cheques Emitidos

## Descripción del proyecto

Sistema web desarrollado como prototipo académico para la gestión de cheques emitidos por comerciantes de la ciudad de Encarnación. El sistema permite registrar, consultar y controlar cheques emitidos, gestionar estados, generar alertas por correo electrónico, emitir reportes operativos y mantener trazabilidad mediante bitácora de eventos.

El proyecto fue desarrollado como Trabajo Fin de Grado de la carrera de Análisis de Sistemas Informáticos de la Universidad Autónoma de Encarnación, dentro de la línea de investigación de Ingeniería de Software.

## Características principales

* Inicio de sesión con nickname y contraseña.
* Control de acceso por roles: Administrador, Supervisor y Operador.
* Gestión de usuarios internos.
* Registro de cheques emitidos.
* Validación de datos obligatorios.
* Control de unicidad por banco, cuenta bancaria y número de cheque.
* Gestión de estados normales y críticos.
* Registro de motivos en estados críticos.
* Control de concurrencia para evitar modificaciones inconsistentes.
* Alertas de vencimiento por correo electrónico mediante SMTP.
* Bandeja de notificaciones pendientes, enviadas y fallidas.
* Reintento manual de notificaciones fallidas.
* Reportes operativos.
* Registro de acciones relevantes en bitácora.

## Tecnologías utilizadas

### Backend

* PHP
* Laravel
* Eloquent ORM

### Frontend

* Blade
* HTML
* CSS
* JavaScript básico

### Base de datos

* PostgreSQL

### Servicios externos

* SMTP externo para envío de correos electrónicos.

### Herramientas de desarrollo

* Visual Studio Code
* DBeaver
* Git
* GitHub
* Trello
* Draw.io

## Requisitos previos

Antes de instalar el proyecto, se requiere contar con:

* PHP compatible con Laravel.
* Composer.
* PostgreSQL.
* Node.js y npm.
* Git.
* Navegador web actualizado.
* Cuenta de correo configurada para pruebas SMTP.

## Instalación del proyecto

### 1. Clonar el repositorio

```bash
git clone https://github.com/aracelipa/gestion-cheques-emitidos.git
cd gestion-cheques-emitidos
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Crear archivo de entorno

Copiar el archivo `.env.example` y renombrarlo como `.env`.

En Windows puede hacerse manualmente copiando el archivo y cambiando el nombre.

### 5. Generar clave de aplicación

```bash
php artisan key:generate
```

### 6. Configurar base de datos

Crear una base de datos en PostgreSQL y configurar el archivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=gestion_cheques
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña
```

### 7. Configurar correo SMTP

Configurar las variables de correo en el archivo `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=correo_de_prueba@example.com
MAIL_PASSWORD=contraseña_de_aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=correo_de_prueba@example.com
MAIL_FROM_NAME="Sistema de Cheques"
```

No se deben subir credenciales reales al repositorio. El archivo `.env` debe permanecer excluido mediante `.gitignore`.

### 8. Ejecutar migraciones

```bash
php artisan migrate
```

Si el proyecto incluye seeders:

```bash
php artisan migrate --seed
```

### 9. Ejecutar recursos frontend

```bash
npm run dev
```

### 10. Iniciar servidor local

```bash
php artisan serve
```

El sistema estará disponible en:

```text
http://127.0.0.1:8000
```

## Variables de entorno principales

| Variable          | Descripción                 | Ejemplo                                         |
| ----------------- | --------------------------- | ----------------------------------------------- |
| APP_NAME          | Nombre de la aplicación     | Sistema de Cheques                              |
| APP_ENV           | Entorno de ejecución        | local                                           |
| APP_KEY           | Clave generada por Laravel  | Generada automáticamente                        |
| APP_DEBUG         | Modo depuración             | true                                            |
| APP_URL           | URL local del sistema       | http://127.0.0.1:8000                           |
| DB_CONNECTION     | Motor de base de datos      | pgsql                                           |
| DB_HOST           | Servidor de base de datos   | 127.0.0.1                                       |
| DB_PORT           | Puerto de PostgreSQL        | 5432                                            |
| DB_DATABASE       | Nombre de base de datos     | gestion_cheques                                 |
| DB_USERNAME       | Usuario de base de datos    | postgres                                        |
| DB_PASSWORD       | Contraseña de base de datos | No incluir valor real                           |
| MAIL_MAILER       | Servicio de correo          | smtp                                            |
| MAIL_HOST         | Servidor SMTP               | smtp.gmail.com                                  |
| MAIL_PORT         | Puerto SMTP                 | 587                                             |
| MAIL_USERNAME     | Correo remitente            | [correo@example.com](mailto:correo@example.com) |
| MAIL_PASSWORD     | Contraseña de aplicación    | No incluir valor real                           |
| MAIL_ENCRYPTION   | Cifrado                     | tls                                             |
| MAIL_FROM_ADDRESS | Correo remitente            | [correo@example.com](mailto:correo@example.com) |
| MAIL_FROM_NAME    | Nombre del remitente        | Sistema de Cheques                              |

## Ejecución completa en local

Para ejecutar el sistema en entorno local, se recomienda utilizar dos terminales.

### Terminal 1

```bash
php artisan serve
```

### Terminal 2

```bash
npm run dev
```

Luego ingresar desde el navegador a:

```text
http://127.0.0.1:8000
```

## Comandos disponibles

| Comando                    | Descripción                              |
| -------------------------- | ---------------------------------------- |
| composer install           | Instala dependencias PHP.                |
| npm install                | Instala dependencias frontend.           |
| php artisan key:generate   | Genera la clave de aplicación.           |
| php artisan migrate        | Ejecuta migraciones.                     |
| php artisan migrate --seed | Ejecuta migraciones y seeders.           |
| php artisan serve          | Inicia el servidor local.                |
| npm run dev                | Compila recursos frontend en desarrollo. |
| php artisan config:clear   | Limpia caché de configuración.           |
| php artisan cache:clear    | Limpia caché general.                    |
| php artisan route:clear    | Limpia caché de rutas.                   |

## Pruebas básicas de funcionamiento

Para verificar el funcionamiento del sistema, se recomienda probar:

1. Inicio de sesión con credenciales válidas.
2. Intento de inicio de sesión con credenciales incorrectas.
3. Creación de usuario interno.
4. Registro de cheque con datos completos.
5. Registro de cheque con datos incompletos.
6. Registro de cheque duplicado.
7. Actualización de estado normal.
8. Gestión de estado crítico con rol Supervisor.
9. Generación de alerta de vencimiento.
10. Revisión de bandeja de notificaciones.
11. Reintento de notificación fallida.
12. Generación de reporte.
13. Consulta de bitácora.
14. Cierre de sesión.

## Posibles problemas y soluciones

### Error de conexión con la base de datos

Causa posible: configuración incorrecta en el archivo `.env` o base de datos no creada.

Solución:

1. Verificar `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`.
2. Confirmar que PostgreSQL esté activo.
3. Crear la base de datos.
4. Ejecutar nuevamente:

```bash
php artisan migrate
```

### Error al enviar correos SMTP

Causa posible: credenciales SMTP incorrectas o contraseña de aplicación inválida.

Solución:

1. Verificar `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME` y `MAIL_PASSWORD`.
2. Usar contraseña de aplicación si se utiliza Gmail.
3. No copiar la contraseña con espacios.
4. Ejecutar:

```bash
php artisan config:clear
```

### Error al leer el archivo .env

Causa posible: espacios o caracteres inválidos en alguna variable.

Solución:

1. Revisar las variables del archivo `.env`.
2. Eliminar espacios innecesarios.
3. Verificar especialmente `MAIL_PASSWORD`.

### Las notificaciones no aparecen en la bandeja

Causa posible: no se generaron registros internos de notificación.

Solución:

1. Verificar que existan cheques próximos a vencer.
2. Revisar la configuración SMTP.
3. Confirmar que el sistema registre los intentos de envío.

### Los montos se ven desalineados en PDF

Causa posible: salto de línea entre el símbolo de guaraníes y el monto.

Solución:

1. Mantener el monto en una sola línea mediante estilo CSS.
2. Aplicar `white-space: nowrap` en la celda correspondiente del reporte.

## Seguridad

El sistema incorpora mecanismos básicos de seguridad acordes al alcance del prototipo:

* Autenticación mediante nickname y contraseña.
* Almacenamiento de contraseñas mediante hash.
* Control de acceso basado en roles.
* Restricción de funciones según perfil.
* Cierre de sesión.
* Control de intentos fallidos.
* Cambio obligatorio de contraseña luego de restablecimiento.
* Registro de acciones relevantes en bitácora.
* Protección de credenciales mediante archivo `.env`.

No deben subirse al repositorio credenciales reales, contraseñas, tokens ni datos sensibles.

## Documentación incluida en el repositorio

Este repositorio contiene:

* Código fuente completo del prototipo.
* Archivo `README.md` con documentación técnica de instalación y ejecución.
* Archivo `.env.example` con variables de entorno de ejemplo, sin credenciales reales.
* Manual de usuario del sistema.
* Documentación del sistema vinculada al Trabajo Fin de Grado.

El archivo `.env` real no se incluye en el repositorio por motivos de seguridad.

## Estado del proyecto

Estado: Prototipo académico funcional.

El sistema fue desarrollado como producto mínimo viable para validación en entorno local. Futuras mejoras pueden incluir despliegue productivo, validación en contexto real, gestión multiempresa, integración con servicios externos y fortalecimiento de seguridad.

## Autor

Araceli Magali Paiva Alfonso
Universidad Nacional Autónoma de Encarnación
Facultad de Ciencia, Arte y Tecnología
Carrera: Análisis de Sistemas Informáticos
Línea de investigación: Ingeniería de Software
Encarnación, Paraguay
Año: 2026
