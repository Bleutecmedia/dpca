<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/

// https://console.developers.google.com
$config['google']['client_id']        = '109666526818-0t2i1n3ita85jpkitj3mmroom4gjc2r2.apps.googleusercontent.com';
$config['google']['client_secret']    = 'z-HEBx3kf6NLtCPlBjtdJryO';
$config['google']['redirect_uri']     = 'http://dialisis.net/dialisis/usuarios/ingresar';
$config['google']['application_name'] = 'Diálisis';
$config['google']['api_key']          = '';
$config['google']['scopes']           = array('email','profile');

/*
|--------------------------------------------------------------------------
| Ajustes SMTP para enviar emails
|--------------------------------------------------------------------------
|
| Usamos la librería PHPMailer https://github.com/PHPMailer/PHPMailer 
|
*/
$config['smtp_name']	=	"Diálisis App Web";
$config['smtp_host']	=	"smtp.gmail.com";
$config['smtp_auth']	=	true;
$config['smtp_secure']	=	"tls";
$config['smtp_user']	=	"";
$config['smtp_pass']	=	"";
$config['smtp_port']	=	"587";

/*
|--------------------------------------------------------------------------
| Ajustes para activar o no la Demo
|--------------------------------------------------------------------------
|
*/
$config['app_name']			=	"DiálApp"; // Nombre de la App
$config['app_version']		=	"1.0.0"; // Versión de la Aplicación