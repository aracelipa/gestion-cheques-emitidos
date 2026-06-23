# Sistema de Gestión de Cheques Emitidos

## Descripción del proyecto

El presente proyecto corresponde al desarrollo de un prototipo web multiusuario para la gestión de cheques emitidos, orientado a comerciantes de la ciudad de Encarnación. El sistema permite registrar, organizar, consultar y controlar cheques emitidos dentro de un entorno digital estructurado, reduciendo la dependencia de registros manuales, agendas físicas o planillas dispersas.

El prototipo fue desarrollado como parte de un Trabajo Fin de Grado de la carrera de Análisis de Sistemas Informáticos. Su alcance corresponde a un producto mínimo viable, centrado en funciones esenciales como gestión de usuarios, control de acceso por roles, registro de cheques emitidos, actualización de estados, alertas por correo electrónico, reportes operativos y bitácora de eventos.

## Características principales

* Inicio de sesión mediante credenciales de usuario.
* Control de acceso basado en roles: Administrador, Supervisor y Operador.
* Gestión de usuarios internos del sistema.
* Registro de cheques emitidos.
* Validación de datos obligatorios del cheque.
* Control de unicidad mediante banco, cuenta bancaria y número de cheque.
* Gestión de estados normales y críticos.
* Registro obligatorio de motivo en estados críticos cuando corresponde.
* Control de concurrencia para evitar modificaciones inconsistentes.
* Envío de alertas por correo electrónico mediante SMTP.
* Bandeja de notificaciones pendientes, enviadas y fallidas.
* Reintento manual de notificaciones fallidas.
* Generación de reportes operativos.
* Registro de eventos relevantes en bitácora.
* Consulta de trazabilidad de acciones realizadas por los usuarios.

## Roles del sistema

### Administrador

El Administrador gestiona usuarios internos, roles, configuraciones básicas y bandeja de notificaciones. También puede revisar notificaciones pendientes, enviadas o fallidas y reintentar envíos cuando corresponda.

### Supervisor

El Supervisor controla operaciones sensibles, gestiona estados críticos de cheques, autoriza reversiones cuando corresponda y accede a reportes del sistema.

### Operador

El Operador registra cheques emitidos, consulta información básica y actualiza estados normales del cheque según las reglas del sistema.

## Tecnologías utilizadas

### Backend y servidor

* PHP
* Laravel
* Eloquent ORM
* Servidor integrado de Laravel para entorno local

### Frontend

* Blade
* HTML
* CSS
* JavaScript básico

### Base de datos

* PostgreSQL

### Servicios externos

* SMTP externo para envío de notificaciones por correo electrónico

### Herramientas de desarrollo y apoyo

* Visual Studio Code
* DBeaver
* Git
* GitHub
* Trello
* Draw.io
* Microsoft Word

## Servicios externos y APIs utilizadas

### Servicio SMTP externo

El sistema utiliza un servicio SMTP externo para el envío de alertas y notificaciones por correo electrónico. Este servicio permite notificar vencimientos próximos o vencimientos del día a los destinatarios registrados.

Para su uso se requiere:

* Cuenta de correo habilitada para envío SMTP.
* Contraseña de aplicación o credencial equivalente.
* Configuración de variables en el archivo `.env`.

Las credenciales reales no deben subirse al repositorio. El archivo `.env` debe mantenerse fuera del control de versiones mediante `.gitignore`.

Variables relacionadas:

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

## Requisitos previos

Antes de instalar el proyecto, se deben tener instaladas las siguientes herramientas:

* PHP 8.2 o superior.
* Composer.
* PostgreSQL 16 o superior.
* Node.js y npm, si se requiere compilar recursos frontend.
* Git.
* Navegador web actualizado, como Chrome, Edge o Firefox.
* DBeaver u otra herramienta para administrar la base de datos.
* Cuenta de correo o servicio SMTP configurado para pruebas de notificaciones.

## Estructura general del proyecto

```text
gestion-cheques/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── ...
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
│
├── routes/
│   └── web.php
│
├── public/
│
├── storage/
│
├── .env.example
├── composer.json
├── package.json
└── README.md
```

### Descripción de carpetas principales

* `app/`: contiene la lógica principal del sistema, modelos, controladores y middleware.
* `database/`: contiene migraciones, seeders y estructura de base de datos.
* `resources/views/`: contiene las vistas Blade del sistema.
* `routes/web.php`: contiene las rutas web del prototipo.
* `public/`: contiene archivos públicos del sistema.
* `storage/`: contiene archivos generados o almacenados por Laravel.
* `.env.example`: archivo de ejemplo para configurar variables de entorno.

## Instalación del proyecto

### 1. Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
cd NOMBRE_DEL_PROYECTO
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Copiar archivo de entorno

```bash
cp .env.example .env
```

En Windows, si el comando anterior no funciona, copiar manualmente el archivo `.env.example` y renombrarlo como `.env`.

### 5. Generar clave de aplicación

```bash
php artisan key:generate
```

### 6. Configurar la base de datos

Crear una base de datos en PostgreSQL. Luego editar el archivo `.env` con los datos correspondientes:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=gestion_cheques
DB_USERNAME=usuario_postgres
DB_PASSWORD=contraseña_postgres
```

### 7. Ejecutar migraciones

```bash
php artisan migrate
```

Si el proyecto incluye seeders para datos iniciales, ejecutar:

```bash
php artisan db:seed
```

O, si corresponde:

```bash
php artisan migrate --seed
```

### 8. Compilar recursos frontend

```bash
npm run dev
```

### 9. Iniciar el servidor local

```bash
php artisan serve
```

El sistema estará disponible normalmente en:

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
| DB_DATABASE       | Nombre de la base de datos  | gestion_cheques                                 |
| DB_USERNAME       | Usuario de base de datos    | postgres                                        |
| DB_PASSWORD       | Contraseña de base de datos | No incluir valor real                           |
| MAIL_MAILER       | Tipo de servicio de correo  | smtp                                            |
| MAIL_HOST         | Servidor SMTP               | smtp.gmail.com                                  |
| MAIL_PORT         | Puerto SMTP                 | 587                                             |
| MAIL_USERNAME     | Correo usado para enviar    | [correo@example.com](mailto:correo@example.com) |
| MAIL_PASSWORD     | Contraseña de aplicación    | No incluir valor real                           |
| MAIL_ENCRYPTION   | Tipo de cifrado             | tls                                             |
| MAIL_FROM_ADDRESS | Correo remitente            | [correo@example.com](mailto:correo@example.com) |
| MAIL_FROM_NAME    | Nombre del remitente        | Sistema de Cheques                              |

## Ejecución completa del proyecto en local

Para ejecutar el sistema en entorno local, se recomienda utilizar dos terminales.

### Terminal 1: servidor Laravel

```bash
php artisan serve
```

### Terminal 2: recursos frontend

```bash
npm run dev
```

Luego ingresar desde el navegador a:

```text
http://127.0.0.1:8000
```

## Comandos disponibles

| Comando                    | Descripción                                   |
| -------------------------- | --------------------------------------------- |
| composer install           | Instala dependencias PHP del proyecto.        |
| npm install                | Instala dependencias frontend.                |
| php artisan key:generate   | Genera la clave de aplicación.                |
| php artisan migrate        | Ejecuta migraciones de base de datos.         |
| php artisan db:seed        | Ejecuta datos iniciales si existen seeders.   |
| php artisan migrate --seed | Ejecuta migraciones y seeders.                |
| php artisan serve          | Inicia el servidor local de Laravel.          |
| npm run dev                | Compila recursos frontend en modo desarrollo. |
| php artisan config:clear   | Limpia caché de configuración.                |
| php artisan cache:clear    | Limpia caché general del sistema.             |
| php artisan route:clear    | Limpia caché de rutas.                        |

## Uso básico del sistema

### Inicio de sesión

1. Acceder a la URL local del sistema.
2. Ingresar nickname y contraseña.
3. Presionar el botón “Ingresar”.
4. El sistema mostrará el panel correspondiente según el rol asignado.

### Registro de cheque emitido

1. Ingresar con un usuario autorizado.
2. Acceder al módulo de cheques.
3. Seleccionar la opción para registrar un nuevo cheque.
4. Completar banco, cuenta, número de cheque, beneficiario, monto, fecha de emisión y fecha de vencimiento.
5. Guardar el registro.
6. El sistema validará los datos y registrará el cheque con su estado inicial.

### Actualización de estados

1. Acceder al listado de cheques.
2. Seleccionar el cheque correspondiente.
3. Elegir la opción de actualización de estado.
4. Seleccionar el nuevo estado permitido.
5. Confirmar la operación.
6. El sistema registrará el cambio en la bitácora.

### Gestión de estados críticos

1. Ingresar con rol Supervisor.
2. Seleccionar el cheque correspondiente.
3. Elegir el estado crítico aplicable.
4. Ingresar motivo obligatorio cuando corresponda.
5. Confirmar la operación.
6. El sistema registrará el evento en la bitácora.

### Notificaciones

1. El sistema genera alertas relacionadas con vencimientos.
2. Las notificaciones pueden quedar pendientes, enviadas o fallidas.
3. El Administrador puede revisar la bandeja de notificaciones.
4. En caso de error, puede reintentar el envío.

### Reportes

1. Ingresar con rol autorizado.
2. Acceder al módulo de reportes.
3. Aplicar filtros por estado, fecha, beneficiario, banco o monto.
4. Visualizar, imprimir o exportar la información disponible.

### Bitácora

1. Acceder al módulo de bitácora.
2. Revisar los eventos registrados.
3. Consultar usuario responsable, fecha, hora y descripción de la acción.

## Pruebas básicas de funcionamiento

Para verificar que el sistema funciona correctamente, se recomienda realizar las siguientes pruebas:

1. Ingresar con credenciales válidas.
2. Intentar ingresar con credenciales incorrectas.
3. Crear un usuario interno con rol asignado.
4. Registrar un cheque con datos completos.
5. Intentar registrar un cheque con datos incompletos.
6. Intentar registrar un cheque duplicado.
7. Actualizar un cheque a un estado normal.
8. Gestionar un estado crítico con rol Supervisor.
9. Verificar que los cambios se registren en la bitácora.
10. Generar una notificación de vencimiento.
11. Revisar la bandeja de notificaciones.
12. Reintentar una notificación fallida.
13. Generar un reporte filtrado.
14. Cerrar sesión correctamente.

## Posibles problemas y soluciones

### Error de conexión con la base de datos

Causa posible: datos incorrectos en el archivo `.env` o base de datos no creada.

Solución:

1. Verificar `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`.
2. Confirmar que PostgreSQL esté activo.
3. Crear la base de datos si aún no existe.
4. Ejecutar nuevamente las migraciones.

```bash
php artisan migrate
```

### Error al enviar correos SMTP

Causa posible: credenciales SMTP incorrectas, contraseña de aplicación inválida o configuración incompleta.

Solución:

1. Revisar las variables `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME` y `MAIL_PASSWORD`.
2. Utilizar contraseña de aplicación si se usa Gmail.
3. No copiar la contraseña con espacios.
4. Limpiar caché de configuración.

```bash
php artisan config:clear
```

### Error al leer el archivo .env

Causa posible: espacios o caracteres inválidos en alguna variable de entorno.

Solución:

1. Revisar que las variables no tengan espacios innecesarios.
2. Si un valor requiere espacios, encerrarlo entre comillas.
3. Verificar especialmente `MAIL_PASSWORD`.

### Las notificaciones no aparecen en la bandeja

Causa posible: no se generaron registros internos de notificación o no se ejecutó el proceso correspondiente.

Solución:

1. Verificar que existan cheques con fechas próximas a vencer.
2. Revisar la lógica de generación de notificaciones.
3. Confirmar que la base de datos registre los intentos de envío.

### Los montos se ven desalineados en PDF

Causa posible: salto de línea entre el símbolo de guaraníes y el monto.

Solución:

1. Aplicar una clase de estilo que mantenga el monto en una sola línea.
2. Usar `white-space: nowrap` en la celda correspondiente del reporte.

## Seguridad

El sistema incorpora mecanismos básicos de seguridad acordes al alcance del prototipo:

* Autenticación mediante nickname y contraseña.
* Almacenamiento seguro de contraseñas mediante hash.
* Control de acceso basado en roles.
* Restricción de funciones según perfil de usuario.
* Cierre de sesión.
* Bloqueo o control de intentos fallidos.
* Registro de acciones relevantes en bitácora.
* Cambio obligatorio de contraseña luego de restablecimiento.
* Protección de credenciales mediante archivo `.env`.
* Exclusión del archivo `.env` del repositorio mediante `.gitignore`.

No deben subirse al repositorio credenciales reales, contraseñas, tokens ni datos sensibles.

## Recomendaciones importantes

* No compartir usuarios ni contraseñas entre personas.
* No subir el archivo `.env` al repositorio.
* Usar `.env.example` para documentar variables necesarias sin incluir valores reales.
* Mantener actualizadas las dependencias del proyecto.
* Revisar periódicamente la bandeja de notificaciones fallidas.
* Verificar que PostgreSQL esté activo antes de ejecutar el sistema.
* Verificar la configuración SMTP antes de probar alertas por correo.
* Usar datos ficticios o de prueba durante la validación académica.
* Cerrar sesión al finalizar el uso del sistema.

## Despliegue

El proyecto fue desarrollado y probado en un entorno local como prototipo académico. No se contempla despliegue productivo definitivo en esta etapa.

Para una futura implementación en producción, se recomienda considerar:

* Servidor web compatible con PHP y Laravel.
* Base de datos PostgreSQL configurada en servidor seguro.
* Certificado SSL/TLS para HTTPS.
* Configuración segura de variables de entorno.
* Servicio SMTP estable.
* Copias de seguridad periódicas.
* Pruebas de seguridad y rendimiento.
* Control de acceso y monitoreo de logs.

## Documentación adicional

Este repositorio debe contener o enlazar los siguientes documentos:

* Trabajo Fin de Grado en formato editable.
* Manual de usuario.
* Documentación técnica del sistema.
* Código fuente completo del prototipo.
* Evidencias de pruebas o anexos correspondientes.

## Autor

Araceli Magali Paiva Alfonso
Universidad Autónoma de Encarnación
Facultad de Ciencia, Arte y Tecnología
Carrera: Análisis de Sistemas Informáticos
Línea de investigación: Ingeniería de Software
Encarnación, Paraguay
Año: 2026

## Estado del proyecto

Estado: Prototipo académico funcional.

El sistema se encuentra desarrollado como producto mínimo viable para validación en entorno local. Las futuras mejoras previstas incluyen validación en contexto real, despliegue productivo, gestión multiempresa, integración con servicios externos y fortalecimiento de seguridad.
