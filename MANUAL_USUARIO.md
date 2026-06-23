# Manual de Usuario e Instalación

## Sistema de Gestión de Cheques Emitidos

## 1. Presentación

El presente manual describe el proceso de instalación, configuración y uso básico del prototipo web **Sistema de Gestión de Cheques Emitidos**. El sistema fue desarrollado como Trabajo Fin de Grado de la carrera de Análisis de Sistemas Informáticos de la Universidad Autónoma de Encarnación.

El prototipo está orientado a comerciantes de la ciudad de Encarnación y permite registrar, consultar, controlar y dar seguimiento a cheques emitidos dentro de un entorno digital estructurado.

El sistema contempla funciones de gestión de usuarios, control de acceso por roles, registro de cheques emitidos, actualización de estados, gestión de estados críticos, alertas por correo electrónico, reportes operativos y bitácora de eventos.

## 2. Alcance del sistema

El sistema fue desarrollado como prototipo académico funcional y producto mínimo viable. Su funcionamiento fue previsto para entorno local, con datos de prueba.

El sistema permite:

* Registrar cheques emitidos.
* Consultar cheques registrados.
* Actualizar estados normales.
* Gestionar estados críticos.
* Registrar motivos en operaciones sensibles.
* Generar alertas por vencimiento.
* Revisar notificaciones pendientes, enviadas y fallidas.
* Generar reportes operativos.
* Registrar acciones relevantes en bitácora.
* Controlar el acceso mediante roles.

El sistema no contempla integración bancaria real, verificación en línea de fondos, OCR, gestión multiempresa, multimoneda ni despliegue productivo definitivo.

## 3. Roles del sistema

El sistema cuenta con tres roles principales: Administrador, Supervisor y Operador.

### 3.1. Administrador

El Administrador gestiona usuarios internos, roles, configuraciones básicas y bandeja de notificaciones. También puede revisar notificaciones pendientes, enviadas o fallidas, además de reintentar envíos cuando corresponda.

### 3.2. Supervisor

El Supervisor controla operaciones sensibles, gestiona estados críticos de cheques, accede a reportes y puede autorizar reversiones cuando corresponda.

### 3.3. Operador

El Operador registra cheques emitidos, consulta información básica y actualiza estados normales del cheque según las reglas del sistema.

## 4. Requisitos previos para la instalación

Antes de instalar el proyecto, se deben tener instaladas las siguientes herramientas:

* PHP 8.2 o superior.
* Composer.
* PostgreSQL 16 o superior.
* Node.js y npm.
* Git.
* Navegador web actualizado, como Chrome, Edge o Firefox.
* DBeaver u otra herramienta para administrar la base de datos.
* Cuenta de correo o servicio SMTP configurado para pruebas de notificaciones.

## 5. Descarga del proyecto

Para obtener el código fuente, se debe clonar el repositorio desde GitHub.

```bash
git clone https://github.com/aracelipa/gestion-cheques-emitidos.git
cd gestion-cheques-emitidos
```

Si el proyecto se descarga manualmente como archivo comprimido desde GitHub, se debe descomprimir la carpeta y abrirla desde el editor de código correspondiente.

## 6. Instalación de dependencias

### 6.1. Instalar dependencias de PHP

Dentro de la carpeta del proyecto, ejecutar:

```bash
composer install
```

Este comando instala las dependencias necesarias del proyecto Laravel.

### 6.2. Instalar dependencias de Node.js

Ejecutar:

```bash
npm install
```

Este comando instala las dependencias necesarias para los recursos frontend del proyecto.

## 7. Configuración del archivo de entorno

El proyecto utiliza un archivo de configuración llamado `.env`. Por seguridad, este archivo no debe subirse al repositorio.

Para configurarlo, copiar el archivo `.env.example` y renombrarlo como `.env`.

En Windows puede realizarse manualmente copiando el archivo `.env.example` y cambiando su nombre a `.env`.

También puede ejecutarse:

```bash
cp .env.example .env
```

Después de crear el archivo `.env`, generar la clave de aplicación:

```bash
php artisan key:generate
```

## 8. Configuración de la base de datos

Crear una base de datos en PostgreSQL. Se recomienda utilizar el nombre:

```text
gestion_cheques
```

Luego editar el archivo `.env` con los datos correspondientes:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=gestion_cheques
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña
```

El valor de `DB_PASSWORD` debe reemplazarse por la contraseña real del usuario local de PostgreSQL.

## 9. Configuración del correo SMTP

El sistema utiliza SMTP externo para el envío de alertas y notificaciones por correo electrónico.

En el archivo `.env`, configurar las siguientes variables:

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

Si se utiliza Gmail, se recomienda utilizar una contraseña de aplicación. La contraseña debe copiarse sin espacios adicionales.

## 10. Ejecución de migraciones

Una vez configurada la base de datos, ejecutar:

```bash
php artisan migrate
```

Si el proyecto cuenta con seeders para datos iniciales, ejecutar:

```bash
php artisan migrate --seed
```

O, si las migraciones ya fueron ejecutadas previamente:

```bash
php artisan db:seed
```

## 11. Ejecución del sistema en entorno local

Para ejecutar el sistema, se recomienda utilizar dos terminales.

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

## 12. Comandos útiles

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

## 13. Acceso al sistema

Para ingresar al sistema, el usuario debe contar con un nickname y contraseña asignados.

Pasos:

1. Abrir el navegador web.
2. Ingresar a la dirección local del sistema.
3. Escribir el nickname.
4. Escribir la contraseña.
5. Presionar el botón “Ingresar”.

Si las credenciales son correctas, el sistema mostrará el panel principal correspondiente al rol asignado.

Si las credenciales son incorrectas, el sistema mostrará un mensaje de error y no permitirá el acceso.

## 14. Recuperación de contraseña

Esta función permite solicitar el restablecimiento de contraseña cuando un usuario no recuerda sus credenciales.

Pasos:

1. Ingresar a la pantalla de inicio de sesión.
2. Presionar la opción “He olvidado mi contraseña”.
3. Ingresar el nickname del usuario.
4. Enviar la solicitud.
5. Esperar la intervención del Administrador.
6. Ingresar posteriormente con la contraseña temporal generada.
7. Cambiar la contraseña cuando el sistema lo solicite.

El sistema exige el cambio de contraseña luego del restablecimiento para reforzar la seguridad del acceso.

## 15. Gestión de usuarios

Esta función está disponible para el rol Administrador.

### 15.1. Crear usuario

Pasos:

1. Ingresar con rol Administrador.
2. Acceder al módulo de usuarios.
3. Seleccionar la opción “Nuevo usuario”.
4. Completar los datos requeridos.
5. Asignar el rol correspondiente.
6. Guardar el registro.

Resultado esperado: el sistema registra el nuevo usuario y asocia el rol seleccionado.

### 15.2. Editar usuario

Pasos:

1. Acceder al listado de usuarios.
2. Seleccionar el usuario correspondiente.
3. Modificar los datos permitidos.
4. Guardar los cambios.

Resultado esperado: el sistema actualiza la información del usuario.

## 15.3. Desactivar usuario

La desactivación o baja de un usuario se realiza desde la pantalla de edición del usuario, cambiando el campo Estado a Inactivo.

Pasos:

1. Ingresar con rol Administrador.
2. Acceder al módulo de usuarios.
3. Seleccionar el usuario correspondiente.
4. Ingresar a la opción de edición.
5. En el campo Estado, seleccionar Inactivo.
6. Guardar los cambios.

Resultado esperado: el usuario queda registrado con estado Inactivo y no podrá acceder al sistema.

Observación: si se desea impedir temporalmente el acceso sin dar de baja al usuario, puede seleccionarse el estado Bloqueado.

## 16. Registro de cheque emitido

Esta función permite cargar un nuevo cheque emitido en el sistema.

Usuario principal: Operador.

Pasos:

1. Ingresar al sistema.
2. Acceder al módulo de cheques.
3. Seleccionar la opción “Registrar cheque”.
4. Completar los datos requeridos:

   * Banco.
   * Cuenta bancaria.
   * Número de cheque.
   * Beneficiario.
   * Monto.
   * Fecha de emisión.
   * Fecha de vencimiento.
5. Revisar que los datos sean correctos.
6. Presionar “Guardar”.

Resultado esperado: el sistema registra el cheque emitido con su estado inicial.

Posibles errores:

* Campos obligatorios incompletos.
* Monto inválido.
* Fechas incorrectas.
* Cheque duplicado por combinación de banco, cuenta bancaria y número de cheque.

## 17. Consulta de cheques emitidos

Esta función permite revisar los cheques registrados en el sistema.

Pasos:

1. Acceder al módulo de cheques.
2. Revisar el listado de cheques emitidos.
3. Utilizar los filtros disponibles, si corresponde.
4. Seleccionar un cheque para ver su detalle.

Resultado esperado: el usuario visualiza la información registrada del cheque, incluyendo datos principales, estado y fechas asociadas.

## 18. Actualización de estado normal

Esta función permite actualizar el estado de un cheque dentro del flujo normal permitido.

Usuario principal: Operador.

Pasos:

1. Acceder al listado de cheques.
2. Seleccionar el cheque correspondiente.
3. Elegir la opción de actualizar estado.
4. Seleccionar el nuevo estado permitido.
5. Confirmar la operación.

Resultado esperado: el sistema actualiza el estado del cheque y registra la acción en la bitácora.

## 19. Gestión de estados críticos

Esta función permite registrar estados críticos como Pagado, Rechazado o Anulado.

Usuario autorizado: Supervisor.

Pasos:

1. Ingresar con rol Supervisor.
2. Acceder al listado de cheques.
3. Seleccionar el cheque correspondiente.
4. Elegir la opción de estado crítico.
5. Seleccionar el estado correspondiente.
6. Ingresar el motivo obligatorio cuando el sistema lo solicite.
7. Confirmar la operación.

Resultado esperado: el sistema actualiza el estado crítico del cheque y registra el evento en la bitácora.

Observación: los estados críticos requieren mayor control, por lo que solo pueden ser gestionados por el Supervisor.

## 20. Reversión de estados

La reversión permite corregir un estado marcado por error sin eliminar el evento original.

Usuario autorizado: Supervisor.

Pasos:

1. Ingresar con rol Supervisor.
2. Seleccionar el cheque correspondiente.
3. Elegir la opción de reversión, si se encuentra disponible.
4. Ingresar el motivo obligatorio.
5. Confirmar la operación.

Resultado esperado: el sistema registra un nuevo evento de corrección y mantiene trazabilidad del cambio realizado.

## 21. Bandeja de notificaciones

Esta función permite revisar el estado de las notificaciones generadas por el sistema.

Usuario autorizado: Administrador.

Estados posibles:

* Pendiente: notificación generada, aún no enviada.
* Enviada: notificación enviada correctamente.
* Fallida: notificación que no pudo ser enviada.

Pasos:

1. Ingresar con rol Administrador.
2. Acceder al módulo de notificaciones.
3. Revisar las pestañas o filtros disponibles:

   * Pendientes.
   * Enviadas.
   * Fallidas.
4. Seleccionar una notificación para revisar su detalle.
5. En caso de notificación fallida, seleccionar la opción de reintento si corresponde.

Resultado esperado: el Administrador puede controlar el estado de las notificaciones y reintentar envíos fallidos.

## 22. Reportes

Esta función permite consultar información organizada sobre los cheques emitidos.

Usuario autorizado: Supervisor.

Pasos:

1. Ingresar con rol Supervisor.
2. Acceder al módulo de reportes.
3. Seleccionar los filtros disponibles:

   * Estado.
   * Fecha.
   * Beneficiario.
   * Banco.
   * Monto.
4. Generar la consulta.
5. Visualizar, imprimir o exportar el reporte según las opciones disponibles.

Resultado esperado: el sistema muestra información organizada para apoyar el seguimiento de los cheques emitidos.

## 23. Bitácora

La bitácora permite revisar eventos relevantes realizados dentro del sistema.

Pasos:

1. Acceder al módulo de bitácora.
2. Revisar el listado de eventos registrados.
3. Consultar la fecha, hora, usuario responsable y descripción de la acción.

Resultado esperado: el sistema permite visualizar la trazabilidad de las operaciones realizadas.

## 24. Cierre de sesión

Al finalizar el uso del sistema, el usuario debe cerrar sesión.

Pasos:

1. Presionar la opción de usuario o menú superior.
2. Seleccionar “Cerrar sesión”.
3. Confirmar la salida si corresponde.

Resultado esperado: el sistema finaliza la sesión activa y retorna a la pantalla de inicio de sesión.

## 25. Pruebas básicas de funcionamiento

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

## 26. Problemas frecuentes y soluciones

### 26.1. Error de conexión con la base de datos

Causa posible: datos incorrectos en el archivo `.env` o base de datos no creada.

Solución:

1. Verificar `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`.
2. Confirmar que PostgreSQL esté activo.
3. Crear la base de datos si aún no existe.
4. Ejecutar nuevamente las migraciones.

```bash
php artisan migrate
```

### 26.2. Error al enviar correos SMTP

Causa posible: credenciales SMTP incorrectas, contraseña de aplicación inválida o configuración incompleta.

Solución:

1. Revisar las variables `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME` y `MAIL_PASSWORD`.
2. Utilizar contraseña de aplicación si se usa Gmail.
3. No copiar la contraseña con espacios.
4. Limpiar caché de configuración.

```bash
php artisan config:clear
```

### 26.3. Error al leer el archivo .env

Causa posible: espacios o caracteres inválidos en alguna variable de entorno.

Solución:

1. Revisar que las variables no tengan espacios innecesarios.
2. Si un valor requiere espacios, encerrarlo entre comillas.
3. Verificar especialmente `MAIL_PASSWORD`.

### 26.4. Las notificaciones no aparecen en la bandeja

Causa posible: no se generaron registros internos de notificación o no se ejecutó el proceso correspondiente.

Solución:

1. Verificar que existan cheques con fechas próximas a vencer.
2. Revisar la lógica de generación de notificaciones.
3. Confirmar que la base de datos registre los intentos de envío.

### 26.5. Los montos se ven desalineados en PDF

Causa posible: salto de línea entre el símbolo de guaraníes y el monto.

Solución:

1. Aplicar una clase de estilo que mantenga el monto en una sola línea.
2. Usar `white-space: nowrap` en la celda correspondiente del reporte.

## 27. Seguridad y recomendaciones

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

Recomendaciones:

* No compartir usuarios ni contraseñas entre personas.
* No subir el archivo `.env` al repositorio.
* Usar `.env.example` para documentar variables necesarias sin incluir valores reales.
* Verificar que PostgreSQL esté activo antes de ejecutar el sistema.
* Verificar la configuración SMTP antes de probar alertas por correo.
* Usar datos ficticios o de prueba durante la validación académica.
* Cerrar sesión al finalizar el uso del sistema.
* Revisar periódicamente la bandeja de notificaciones fallidas.

## 28. Archivos que no deben subirse al repositorio

Por seguridad y buenas prácticas, no deben subirse los siguientes archivos o carpetas:

```text
.env
vendor/
node_modules/
```

Tampoco deben subirse contraseñas reales, tokens, claves privadas ni credenciales de correo o base de datos.

## 29. Estado del sistema

Estado: Prototipo académico funcional.

El sistema se encuentra desarrollado como producto mínimo viable para validación en entorno local. Las futuras mejoras previstas incluyen validación en contexto real, despliegue productivo, gestión multiempresa, integración con servicios externos y fortalecimiento de seguridad.

## 30. Datos de la autora

Araceli Magali Paiva Alfonso
Universidad Autónoma de Encarnación
Facultad de Ciencia, Arte y Tecnología
Carrera: Análisis de Sistemas Informáticos
Línea de investigación: Ingeniería de Software
Encarnación, Paraguay
Año: 2026
