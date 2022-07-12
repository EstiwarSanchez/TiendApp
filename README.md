<div><div data-rich-type="markup" data-path="README.md" class="blob-viewer">
<div class="file-content md">
<h1 dir="auto" data-sourcepos="1:1-1:29">
<a aria-hidden="true" href="#configuraci%C3%B3n-del-proyecto" class="anchor" id="user-content-configuración-del-proyecto"></a>Configuración del proyecto</h1>
<p dir="auto" data-sourcepos="3:1-3:165">De acuerdo a los requerimientos de la prueba para desarrollo practico en el proceso de selección, estos son los puntos a seguir para la configuración del proyecto.</p>
<ul dir="auto" data-sourcepos="5:1-13:0">
<li data-sourcepos="5:1-5:108">Se asume como primer punto que apache, mysql y php ya han sido instalados y configurados en el servidor.</li>
<li data-sourcepos="6:1-6:70">Instalar composer de manera global para nuestro sistema operativo.</li>
<li data-sourcepos="7:1-7:44">Crear la base de datos en nuestro mysql.</li>
<li data-sourcepos="8:1-8:73">Bajar el repositorio al servidor donde correremos nuesta aplicación.</li>
<li data-sourcepos="9:1-9:80">Configurar el archivo con las variables de entorno para nuestra aplicación.</li>
<li data-sourcepos="10:1-10:40">Bajar las dependencias del proyecto.</li>
<li data-sourcepos="11:1-11:79">Realizar migraciones de las tablas a la base de datos y correr el proyecto.</li>
<li data-sourcepos="12:1-13:0">Contruir aplicación front</li>
</ul>
<h2 dir="auto" data-sourcepos="14:1-14:20">
<a aria-hidden="true" href="#instalar-composer" class="anchor" id="user-content-instalar-composer"></a>Instalar composer</h2>
<p dir="auto" data-sourcepos="16:1-16:195">En el siguiente enlace podemos encontrar una guía completa sobre la instalación y configuración de Composer en nuestro S.O de manera global <a rel="nofollow noreferrer noopener" href="https://getcomposer.org/doc/00-intro.md">composer</a>.</p>
<h2 dir="auto" data-sourcepos="18:1-18:22">
<a aria-hidden="true" href="#crear-base-de-datos" class="anchor" id="user-content-crear-base-de-datos"></a>Crear base de datos</h2>
<p dir="auto" data-sourcepos="20:1-20:210">Creamos la base de datos para nuestra aplicación, acontinuación podemos ver el comando para realizar esto en nuestro mysql, <code>nombre_bd</code> puede ser cualquier denominación sin caracteres especiales ni espacios.</p>
<ul dir="auto" data-sourcepos="22:1-23:0">
<li data-sourcepos="22:1-23:0">CREATE DATABASE <code>nombre_bd</code> CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</li>
</ul>
<h3 dir="auto" data-sourcepos="24:1-24:22">
<a aria-hidden="true" href="#clonar-repositorio" class="anchor" id="user-content-clonar-repositorio"></a>Clonar repositorio</h3>
<p dir="auto" data-sourcepos="25:1-25:130">Copiamos el repositorio al root de nuestro servidor apache, <em>tiendApp</em> puede ser cualquier denominación sin caracteres especiales.</p>
<ul dir="auto" data-sourcepos="27:1-29:0">
<li data-sourcepos="27:1-27:60">git clone <a href="https://github.com/EstiwarSanchez/TiendApp/">https://github.com/EstiwarSanchez/TiendApp/</a> <em>tiendaApp</em>
</li>
<li data-sourcepos="28:1-29:0">Ahora ingresamos a nuestra carpeta <strong>api</strong>, de aquí en adelante los pasos a seguir son dentro de esta ruta</li>
</ul>
<h2 dir="auto" data-sourcepos="30:1-30:18">
<a aria-hidden="true" href="#configurar-env" class="anchor" id="user-content-configurar-env"></a>Configurar .env</h2>
<p dir="auto" data-sourcepos="32:1-32:226">Después de clonar nuestro repositorio, accedemos a nuestro proyecto desde la terminal, luego debemos duplicar el archivo <strong>.env.example</strong> con el nombre del nuevo archivo igual a <strong>.env</strong> y configurar las siguientes variables.</p>
<ul dir="auto" data-sourcepos="34:1-43:0">
<li data-sourcepos="34:1-34:33">comando: cp .env.example .env</li>
<li data-sourcepos="35:1-43:0">variables
<ol data-sourcepos="36:5-43:0">
<li data-sourcepos="36:5-36:59">APP_NAME = 'El nombre que queramos para el proyecto'</li>
<li data-sourcepos="37:5-37:61">APP_URL = 'Url o IP designada para correr el proyecto'</li>
<li data-sourcepos="38:5-38:49">DB_HOST = HOST para nuestro servidor mysql</li>
<li data-sourcepos="39:5-39:51">DB_PORT = PUERTO para nuestro servidor mysql</li>
<li data-sourcepos="40:5-40:59">DB_DATABASE = Nombre de la base de datos que creamos</li>
<li data-sourcepos="41:5-41:47">DB_USERNAME = Nombre de usuario de mysql</li>
<li data-sourcepos="42:5-43:0">DB_PASSWORD = Si el usuario tiene contraseña</li>
</ol>
</li>
</ul>
<h2 dir="auto" data-sourcepos="44:1-44:15">
<a aria-hidden="true" href="#dependencias" class="anchor" id="user-content-dependencias"></a>Dependencias</h2>
<p dir="auto" data-sourcepos="46:1-46:136">Ejecute los siguientes comandos desde la consola dentro de nuestra carpeta raiz del proyecto para instalar todas las dependecias de php.</p>
<ul dir="auto" data-sourcepos="48:1-51:0">
<li data-sourcepos="48:1-48:14">composer i</li>
<li data-sourcepos="49:1-49:28">php artisan config:cache</li>
<li data-sourcepos="50:1-51:0">php artisan key:generate</li>
</ul>
<h2 dir="auto" data-sourcepos="52:1-52:67">
<a aria-hidden="true" href="#correr-migraciones-para-la-base-de-datos-y-correr-la-aplicaci%C3%B3n" class="anchor" id="user-content-correr-migraciones-para-la-base-de-datos-y-correr-la-aplicación"></a>Correr migraciones para la base de datos y correr la aplicación</h2>
<p dir="auto" data-sourcepos="54:1-54:93">Ejecute los siguientes comandos desde la consola dentro de nuestra carpeta raiz del proyecto.</p>
<ul dir="auto" data-sourcepos="56:1-64:0">
<li data-sourcepos="56:1-56:23">php artisan migrate --seed</li>
<strong>Editamos las siguientes variables de entorno en nuestro archivo .env</strong>
</li>
<strong>Para finalizar corremos el servidor</strong>
</li>
<li data-sourcepos="63:1-64:0">
<em>php artisan serve</em> , este comando no es necesario si tenemos un servidor para descubrir nuestras aplicaciones automaticamente, simplemente accedemos a la url configurada en nuestro servidor para la aplicación</li>
</ul>
<p dir="auto" data-sourcepos="65:1-65:77">Ahora puede acceder a la aplicación api, por medio de la ip o url designada.</p>
<h2 dir="auto" data-sourcepos="67:1-67:36">
<a aria-hidden="true" href="#construir-la-aplicaci%C3%B3n-de-front" class="anchor" id="user-content-construir-la-aplicación-de-front"></a>Construir la aplicación de front</h2>
<p dir="auto" data-sourcepos="69:1-69:81">volvemos a la carpeta raíz de nuestro proyecto e ingresamos a la carpeta cliente</p>
<ul dir="auto" data-sourcepos="71:1-76:0">
<li data-sourcepos="71:1-71:98">Instalamos NodeJs para nuestro sistema operativo, esto para poder instalar dependecias con npm</li>
<li data-sourcepos="72:1-72:71">ejecutamos en la consola <strong>npm install npm -g</strong> para actualizar npm</li>
<li data-sourcepos="74:1-74:141">Luego dentro de la carpeta raiz cliente ejecutamos el comando en la consola <strong>npm run dev</strong> para construir nuestra aplicación de front</li>
<li data-sourcepos="75:1-76:0">Ahora solo queda servir los archivos resultantes en la carpeta dist a un servidor y podemos utilizar la aplicación.</li>
</ul>
<p dir="auto" data-sourcepos="77:1-77:198">Cualquier duda sobre la configuración del proyecto, puede comunicarse conmigo por medio de correo electrónico. <a href="mailto:mailyonierestiwar1999@gmail.com">yonierestiwar1999@gmail.com</a></p>
</div>

</div>
</div>
