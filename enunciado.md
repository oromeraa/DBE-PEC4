
# M4.276 - Desenvolupament back-end - Aula 2 | Desarrollo back-end - Aula 2 - Enunciado de la actividad R4
## Planteamiento
En esta práctica introduciremos un nuevo reto. Desarrollaremos el backend de un sitio web con autenticación y endpoints de API de consulta básica. Lo realizaremos  de forma similar a como lo hemos hecho en las PECs anteriores con PHP y Drupal pero utilizando el framework Laravel y sus herramientas asociadas.

## Descripción y requisitos
Emplearemos Laravel para crear un gestor básico de museos / exposiciones almacenados en una base de datos MySQL. 

En adelante se mencionará “museos” para referirnos de forma genérica tanto a museos como a exposiciones.

A continuación se indican los requisitos fundamentales que debe cumplir el gestor que queremos desarrollar.

 

R1. La estructura de contenidos que se propone estará formada por dos entidades, “museum” y “topic”.

Por una parte, la entidad museum (museo) dispondrá de los siguientes campos:

Nombre del museo (texto inferior a 255 caracteres).
Ciudad (campo de texto).
Temática de las colecciones del museo (como *entidad referenciada*).
Fechas y horarios (campo de texto)
Visitas guiadas (como tipo enumerado; valores posibles: “sí”, “no”). 
Precio
Imagen de portada (almacenaremos sólo la ruta y el nombre del archivo).
Por otra parte, la entidad “topic” (temática) sólo podrá contener determinados valores, por ejemplo, arqueología, ciencia, historia del arte, etc.

Para definir las relaciones entre las dos entidades, “museum” y “topic”, tendremos en cuenta que un museo puede albergar colecciones de distintas temáticas (por ejemplo, el Museo Británico alberga colecciones de arqueología, historia del arte e historia del mundo, entre otras).

Consideraciones:

El campo “visitas guiadas” podemos definirlo como tipo enumerado. En el siguiente recurso podéis encontrar un ejemplo:
https://laracasts.com/series/whats-new-in-laravel-9/episodes/10Links to an external site.

Para reducir el alcance del reto, se propone asumir que en este sitio web habrá como máximo un museo por ciudad. Por este motivo, el campo “ciudad” se propone definirlo como campo de texto en lugar de una nueva entidad referenciada.
 

R2. El sitio web tendrá un menú con las siguientes opciones: 

Home. Página de inicio. Muestra un listado de sólo 5 museos. Esta opción de menú se visualizará en todas las páginas.

API_museums. Acceso al endpoint / api / museums / 1  , que devolverá en formato JSON la primera página de los museos (actividad 6). Esta opción de menú se visualizará en todas las páginas (excepto en la propia API JSON) y la API se abrirá en una nueva pestaña del navegador

API_museum. Acceso al endpoint / api / museum / 1  , que devolverá en formato JSON el museo cuyo identificador es 1 (actividad 6) . Esta opción de menú se visualizará en todas las páginas (excepto en la propia API JSON) y la API se abrirá en una nueva pestaña del navegador

API_topic. Acceso al endpoint / api / topic / 1 / 1 , que devolverá en formato JSON la primera página de los museos cuya temática tiene identificador 1 (actividad 6). Esta opción de menú se visualizará en todas las páginas (excepto en la propia API JSON) y la API se abrirá en una nueva pestaña del navegador.

Log in. Opción creada automáticamente por Laravel Breeze en la actividad 2. Permite acceder al formulario de autenticación (/login). Esta opción de menú sólo se visualizará  cuando un usuario no está logueado. 

Register. Opción creada automáticamente por Laravel Breeze en la actividad 2. Permite acceder al formulario de registro (/register). Esta opción de menú sólo se visualizará cuando un usuario no está logueado. 

Dashboard. Opción creada automáticamente por Laravel Breeze en la actividad 2. Permite acceder a las opciones “Profile” y “Log Out”. Esta opción de menú sólo se visualizará cuando un usuario está logueado.

Profile. Opción creada automáticamente por Laravel Breeze en la actividad 2. Permite acceder al perfil del usuario. Esta opción de menú sólo se visualizará  cuando un usuario está logueado. 

Log Out. Opción creada automáticamente por Laravel Breeze en la actividad 2. Permite cerrar la sesión del usuario. Esta opción de menú sólo se visualizará  cuando un usuario está logueado. 

Ten en cuenta que cinco de estas opciones (log in, register, dashboard, profile y log out) se crearán automáticamente por Laravel Breeze en la actividad 2 de este reto.

 

## Actividades
A partir de este caso de estudio, deberás realizar las siguientes actividades y documentarlas siguiendo las instrucciones indicadas en la sección “Formato de entrega”.

Siempre que se realice una captura de pantalla de una ventana de un navegador se deberá incluir la barra de direcciones. El objetivo es que aparezca la URL en la captura de pantalla original.

Para implementar el sitio web de museos principalmente seguiremos los siguientes pasos:

Instalación de Laravel
Creación del sistema de autenticación
Creación de las migraciones, modelos y controladores necesarios
Creación de "fakers" y "seeders" (sistema para generar contenidos ficticios de Laravel)
Implementación del frontend de la aplicación
Desarrollo de APIs de consulta de datos
Migración al servidor de pruebas
En concreto se pide realizar las siguientes actividades:


### Actividad 1. Instalación de Laravel (0,5 puntos)

En primer lugar, deberás instalar Laravel en tu ordenador con composer (opción recomendada) y comprobar su funcionamiento. En esta actividad deberás comentar posibles problemas y cómo los has  solucionado. 

Se recomienda utilizar la versión 12 de Laravel, que es la última versión en el momento de redactar este enunciado, pero se puede utilizar una versión anterior si se justifica adecuadamente.

Seguidamente configuraremos Laravel para trabajar con una base de datos MySQL.

Además, compararemos el proceso de instalación de Laravel con el de Drupal en la PEC2.




### Actividad 2. Sistema de autenticación (1 punto)

En este apartado añadiremos un sistema de autenticación básico. Emplearemos la librería Breeze de Laravel, que nos facilitará esta tarea.

Durante la instalación, seleccionaremos la opción “blade”. Podéis encontrar más información acerca de Laravel Breeze en la sección 6.1 del material “El framework Laravel” que encontrarás en los recursos del aula. 

Una vez instalado Breeze, comprobaremos que se ha creado automáticamente un menú en la parte superior de la página de inicio, con las opciones Log in y Register.

A través de la opción Register accederemos a la ruta /register y daremos de alta un usuario de prueba cuyas credenciales han de ser:

email (no real): admin@fakemail.com

usuario: admin

contraseña: uoc-25-S1@

A continuación cerraremos la sesión (opción de menú logout) y accederemos a /login a través del menú para comprobar que podemos autenticarnos con el usuario que acabamos de crear.

En la vista correspondiente modificaremos el mensaje de bienvenida a “Nos alegramos de volverte a ver, <username>!”, donde <username> mostrará el nombre del usuario logueado en ese momento.

También comprobaremos el correcto funcionamiento de la opción de menú “profile”.

 

### Actividad 3. Crear las migraciones y modelos necesarios. Uso de Tinker (1,5 puntos)

A partir de las especificaciones de la aplicación descritas en R1, crearemos las migraciones, los modelos necesarios y la relación entre las dos entidades a través de una “pivot table”.

Con la herramienta Tinker, crearemos al menos dos museos reales con todos sus campos y asignaremos cada museo como mínimo a dos temáticas distintas.

Para trabajar con Tinker, puedes consultar la sección 5.2 del material “El framework Laravel” que encontrarás en los recursos del aula.

 

### Actividad 4. Generar contenidos ficticios (1,5 puntos)

Crearemos también museos ficticios. Para generarlos utilizaremos Factory, que es un mecanismo que nos permite generar datos de prueba en la base de datos.

Concretamente, utilizaremos la herramienta Faker para generar los contenidos ficticios de forma automática. Para activarlo, crearemos un seeder y lo llamaremos con el comando:

php artisan db:seed

Encontraréis más información en este enlace:

https://laravel.com/docs/12.x/seedingLinks to an external site.

Para cada museo también generaremos una imagen única (no se podrá repetir).

También de forma automática, crearemos al menos 40 museos y 4 temáticas. Se deberá cumplir que al menos 20 de estos museos alberguen cada uno como mínimo 2 de las temáticas generadas (esto permitirá testear con mayor facilidad la paginación de las APIs).

 

### Actividad 5. Implementar el frontend de la aplicación (2 puntos)

Aunque esta PEC se centra en el backend-API, vemos interesante trabajar cómo integrar Laravel en frontends básicos.

Utilizaremos el ORM Eloquent (proporcionado por Laravel) para acceder a la base de datos.

Deberás crear una página de inicio que muestre un listado de sólo 5 museos (sin paginación). Dos de los museos serán fijos porque han de ser los museos reales que habéis creado en la actividad 3. Los 3 museos restantes serán aleatorios para que cada vez que se cargue la página sean museos distintos.

De cada uno de los museos se mostrará el nombre del museo (enlazado a la página única del museo), el campo ciudad, la imagen del museo y el precio.

Será necesario crear la página única de cada uno de los museos, donde se mostrarán todos los campos del museo en cuestión.

Añadiremos las opciones de menú Home, API_museums,  API_museum y API_topic, descritas en R2.

Para evitar problemas de rutas al publicar vuestro proyecto en el servidor de pruebas, en las vistas se recomienda utilizar el helper “url” de Laravel para las rutas y “asset” para los archivos. En los siguientes recursos encontraréis más información:

https://laravel.com/docs/12.x/urlsLinks to an external site.

https://laravel.com/docs/12.x/helpers#method-assetLinks to an external site.




### Actividad 6. API (2 puntos)

A continuación desarrollaremos los siguientes puntos de entrada API (de sólo lectura) y comprobaremos su funcionamiento en un navegador web. Gestionaremos las rutas de las APIs a través del correspondiente Middleware de Laravel.

En el documento de pruebas, recordar adjuntar capturas de pantalla donde se visualicen las URLs empleadas y los resultados en cada uno de los casos siguientes:

- / api / museums / <page> 

El parámetro < page > permite seleccionar cada una de las páginas de resultado (has de configurar 5 museos por página). Devuelve un listado en formato JSON de todos los campos de cada uno de los museos.

- / api / museum / <id> 

Donde < id > es el identificador único de cada museo. Devuelve un listado en formato JSON de todos los campos del museo especificado.

/ api / topic / <id> / <page>

Donde < id > es el identificador único de la temática. Devuelve un listado en formato JSON con sólo los campos nombre, id y ciudad de cada uno de los museos de la temática especificada, y < page > permite seleccionar la página de resultados deseada (5 museos por página).

En caso de especificar un identificador y/o página que no exista en cualquiera de las tres APIs, deberemos devolver un código de estado HTTP 404 Not Found.

 

### Actividad 7. Publicación (1 punto)

Finalmente deberás migrar el prototipo al servidor de pruebas. Se han de documentar todos los pasos seguidos y comprobar su funcionamiento (login, registro, api, página única de cada museo, etc).

Documentaremos todos los pasos seguidos para este propósito. En el formulario de entrega se deberá proporcionar, entre otros, la URL del sitio web finalizado en el servidor de pruebas.

 

### Actividad 8 (0,5 puntos)

Comenta e ilustra con *ejemplos concretos basados en tu experiencia* (por ejemplo, comentar tu experiencia implementando la parte de login, las APIs, etc) al menos 3 ventajas y 3 inconvenientes que has encontrado en cada uno de los tres entornos utilizados para realizar este tipo de aplicación (Drupal en la PEC2, PHP en la PEC3 y Laravel en esta PEC4).

 

## Formato de entrega
La entrega se realizará a través del apartado correspondiente del aula virtual. Se valorará el funcionamiento del resultado en el servidor y la adecuada documentación del proceso.

### Entregables:

Se deberán entregar dos documentos en formato PDF, compartir el código y rellenar un formulario con los datos de acceso al proyecto publicado en el servidor remoto. Concretamente, se deberá entregar:

 

###1- Explicación del desarrollo de la actividad.

Nombre del archivo: pec4_documento_1_explicaciones_Apellidos_Nombre.pdf

Se debe explicar detalladamente cómo se ha realizado la actividad, incluyendo los errores encontrados (si los hubiera) y las soluciones aplicadas.

Se pueden incluir capturas de pantalla para ilustrar el proceso.

La extensión máxima permitida es de 1 página por tarea. No se establecen restricciones de formato (interlineado, tamaño de fuente, etc.), pero el incumplimiento del límite de extensión será penalizado.

 

### 2- Documentación de pruebas.

Nombre del archivo: pec4__documento_2_pruebas_Apellidos_Nombre.pdf

Se deben documentar las pruebas realizadas para verificar que la actividad cumple con los requisitos establecidos.

Se deben incluir capturas de pantalla que evidencien el correcto funcionamiento.

Es necesario acompañar cada prueba con una breve explicación de los pasos seguidos.

No hay límite de extensión, ya que el contenido principal consistirá en capturas de pantalla.

 

### 3- Código y base de datos.

Para poder superar el reto, es condición indispensable compartir tanto la carpeta del proyecto como la base de datos. Para ello, subiremos un archivo comprimido a Google Drive que contenga el proyecto y la base de datos. En el formulario del siguiente paso añadiremos el enlace de descarga.

 

### 4- Datos de acceso al proyecto.

Se debe rellenar el siguiente formulario con los datos de acceso al proyecto y con en enlace de descarga del código y la base de datos:

https://forms.gle/Fk64HVhheVWTim1G7Links to an external site.




##Evaluación
Las actividades de este reto se evaluarán de la manera indicada en cada tarea.

 

La nota de este reto constituye un 30% sobre la nota final de la asignatura. 

 

Recuerda que para acogerte a la evaluación continua de la asignatura, y superarla, deberás superar todos los retos. Un reto se considera superado si obtienes una nota igual o superior a 3 puntos.

 

## Propiedad intelectual y plagio
La Normativa académica de la UOC dispone que el proceso de evaluación se cimenta en el trabajo personal del estudiante y presupone la autenticidad de la autoría y la originalidad de los ejercicios realizados.

La ausencia de originalidad en la autoría o el mal uso de las condiciones en las que se realiza la evaluación de la asignatura, es una infracción que puede tener consecuencias académicas graves.

Te recomendamos leer esta guía sobre el plagio académico y cómo evitarlo. Recuerda que siempre que reutilices contenido de terceros debes citar la fuente, puedes leer también esta guía para saber cómo citar correctamente.

El estudiante será calificado con un suspenso (D/0) si se detecta falta de originalidad en la autoría de alguna prueba de evaluación contínua (PEC) o final (PEF), sea porque haya utilizado material o dispositivos no autorizados, sea porque ha copiado textualmente de internet, o ha copiado apuntes, de PEC, de materiales, manuales o artículos (sin la cita correspondiente) o de otro estudiante, o por cualquier otra conducta irregular.

 

