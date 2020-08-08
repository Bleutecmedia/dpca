<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ci3_google_auth
 *
 * Librería para inicio de sesión de Google. Ayuda al usuario a iniciar sesión con su cuenta de Google
 * en una aplicación con CodeIgniter 3.x.
 *
 * Esta librería requiere la instalación de google/apiclient vía composer
 * Tambén se requiere agregar en el archivo de configuración app.php los ajustes de Google API.
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author ING. S.C. Rigoberto Alejandres García
 * @link https://bleutecmedia.com
 * @license MIT
 */
class Google{
    
    // Método constructor de la Librería
    public function __construct(){

        // Obtenemos instancia de CodeIgniter
        $CI =& get_instance();

        // Creamos una instancia del cliente de Google.
        $this->client = new Google_Client();

        // Procedemos a especificar los datos de autirización desde los ajustes de app.php
        $this->client->setApplicationName($CI->config->item('application_name', 'google'));
        $this->client->setClientId($CI->config->item('client_id', 'google'));
        $this->client->setClientSecret($CI->config->item('client_secret', 'google'));
        $this->client->setRedirectUri($CI->config->item('redirect_uri', 'google'));
        $this->client->setDeveloperKey($CI->config->item('api_key', 'google'));
        $this->client->setScopes($CI->config->item('scopes', 'google'));
        $this->client->setAccessType('online');
        $this->client->setApprovalPrompt('auto');

        // Intentamos obtener una instancia de autorización para nuestro cliente
        $this->oauth2 = new Google_Service_Oauth2($this->client);
    }

	/**
	 * Cree una URL para obtener la autorización del usuario. El punto final de autorización permite
	 * al usuario autenticarse primero y luego otorgar / denegar la solicitud de acceso.
	 * @return string
	 */
    public function loginURL() {
        return $this->client->createAuthUrl();
    }

	/**
	 * Para alias de compatibilidad con versiones anteriores para fetchAccessTokenWithAuthCode
	 * @param string $code
	 * @return array
	 */
    public function getAuthenticate($code="") {
        return $this->client->authenticate($code);
    }


	/**
	 * Obtiene un Token de acceso para un Usuario.
	 * @return array
	 */
    public function getAccessToken() {
        return $this->client->getAccessToken();
    }

	/**
	 * Establezca el token de acceso utilizado para las solicitudes.
	 */
    public function setAccessToken() {
        return $this->client->setAccessToken();
    }

	/**
	 * Revocar un token de acceso OAuth2 o token de actualización.
	 * Este método revocará el token de acceso actual, si no se proporciona un token.
	 * @return bool
	 */
    public function revokeToken() {
        return $this->client->revokeToken();
    }

	/**
	 * Retorna información de un Usuario.
	 * @return Google_Service_Oauth2_Userinfo
	 */
    public function getUserInfo() {
        return $this->oauth2->userinfo->get();
    }
    
}
