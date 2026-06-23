# gestion-cheques-emitidos

# Prototipo web para la gestión de cheques emitidos desarrollado como Trabajo Fin de Grado.

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

## Roles del sistema

### Administrador

Gestiona usuarios internos, roles, configuraciones básicas y bandeja de notificaciones. Puede revisar notificaciones pendientes, enviadas y fallidas, además de reintentar envíos cuando corresponda.

### Supervisor

Gestiona operaciones sensibles, estados críticos, reportes y reversión de estados cuando corresponda.

### Operador

Registra cheques emitidos, consulta información y actualiza estados normales del cheque.

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

* SMTP externo para envío de correos electrónicos

### Herramientas de desarrollo

* Visual Studio Code
* DBeaver
* Git
* GitHub
* Trello
* Draw.io

## Servicios externos utilizados

### Servicio SMTP

El sistema utiliza un servicio SMTP externo para enviar alertas de vencimiento de cheques por correo electrónico.

Para su funcionamiento se requiere configurar las credenciales SMTP en el archivo `.env`. Si se utiliza Gmail, se recomienda generar una contraseña de aplicación.

Ejemplo de configuración:

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

## Requisitos previos

Antes de instalar el proyecto, se requiere contar con:

* PHP compatible con Laravel.
* Composer.
* PostgreSQL.
* Node.js y npm.
* Git.
* Navegador web actualizado, como Chrome, Edge o Firefox.
* Cuenta de correo configurada para pruebas SMTP.

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

### 7. Ejecutar migraciones

```bash
php artisan migrate
```

Si el proyecto incluye datos iniciales mediante seeders:

```bash
php artisan migrate --seed
```

### 8. Ejecutar recursos frontend

```bash
npm run dev
```

### 9. Iniciar servidor local

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

## Uso básico del sistema

### Inicio de sesión

1. Ingresar a la URL local del sistema.
2. Escribir nickname y contraseña.
3. Presionar “Ingresar”.
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
4. Ingresar el motivo obligatorio cuando corresponda.
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
3. Aplicar filtros disponibles.
4. Visualizar, imprimir o exportar la información según corresponda.

### Bitácora

1. Acceder al módulo de bitácora.
2. Revisar los eventos registrados.
3. Consultar usuario responsable, fecha, hora y descripción de la acción.

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

## Recomendaciones importantes

* No subir el archivo `.env` al repositorio.
* Usar `.env.example` para documentar variables sin incluir valores reales.
* Mantener `.env` dentro de `.gitignore`.
* No compartir usuarios ni contraseñas.
* Usar datos ficticios durante pruebas académicas.
* Verificar que PostgreSQL esté activo antes de iniciar el sistema.
* Verificar la configuración SMTP antes de probar alertas.
* Cerrar sesión al finalizar el uso del sistema.

## Despliegue

El proyecto fue desarrollado y probado en entorno local como prototipo académico. No se contempla despliegue productivo definitivo en esta etapa.

Para una futura implementación en producción se recomienda considerar:

* Servidor web compatible con PHP y Laravel.
* Base de datos PostgreSQL configurada en servidor seguro.
* Certificado SSL/TLS para HTTPS.
* Configuración segura de variables de entorno.
* Servicio SMTP estable.
* Copias de seguridad.
* Pruebas de seguridad y rendimiento.

## Documentación adicional

Este repositorio contiene o debe contener:

* Código fuente completo del prototipo.
* Archivo README con documentación técnica.
* Manual de usuario.
* Documentación del sistema.
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

El sistema fue desarrollado como producto mínimo viable para validación en entorno local. Futuras mejoras pueden incluir despliegue productivo, validación en contexto real, gestión multiempresa, integración con servicios externos y fortalecimiento de seguridad.
