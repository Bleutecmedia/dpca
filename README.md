## DiáliApp - Aplicación para Gestionar Diálisis Peritoneal Ambulatoria (DPCA)

Aplicación Web simple construida en **CodeIgniter 3.x** para realizar el control de la Diálisis Peritoneal Ambulatoria (DPCA)
del IMSS (aplicación no oficial). 

### Default Login
- **User**: admin@admin.com
- **Pass**: password

### DEMO
[https://dpca.bleutecmedia.com/](https://dpca.bleutecmedia.com/)

<p align="center">
    <img src="https://i.ibb.co/3MjBjF6/Screenshot-2020-08-10-Di-li-App-1.png">
</p>

## Instalación
- 1.- **Clone el proyecto en el Path de su Servidor Web**

`git clone git@github.com:Bleutecmedia/dialisis.git`


- 2.- **Dentro de `dialisis` instale las librerías necesarias vía composer:**

`composer install`

- 3.- **Puede tener configurado en `application/config/config.php` la carga automática de Composer con:**

`$config['base_url'] = 'http://dialisis.net/dialisis/';`

- 4.- **Crear las credenciales en nuetro Proyecto en la Consola Google para la Autenticación**
Ir a [https://console.developers.google.com/](https://console.developers.google.com/)
Seguir las instrucciones de las capturas de la carpeta `images`. 

Agregar en `application/config/app.php` el ID del Cliente y la Clave secreta obtenidas. El siguiente es un ejemplo
```php
$config['google']['client_id']        = 'asdasdasd.apps.googleusercontent.com';
$config['google']['client_secret']    = 'asdasd2wd';
$config['google']['redirect_uri']     = 'http://ci3-google-auth.net/ci3_google_auth/login/ingreso';
$config['google']['application_name'] = 'DialiApp';
$config['google']['api_key']          = '';
$config['google']['scopes']           = array('email','profile');
```
- 7.- Si está usando servidor local, para el caso de Windows agregar en `C:\Windows\System32\drivers\etc\hosts`
`127.0.0.1 	 http://dialisis.net` para poder probar el login, ya que la Aplicación de Google no permite
agregar URL locales para probar el Auth.

- 6.- Importar la base de datos desde `assets/db/dialisis.sql`

- 7.- Acceder a `http://dialisis.net/dialisis` para iniciar sesión con google.

- 8.- Probar y adecuar.
