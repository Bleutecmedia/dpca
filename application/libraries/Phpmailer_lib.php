<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Para enviar el correo con PHPMailer 6
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Phpmailer_lib{

    public function __construct(){
		$CI = & get_instance();
        log_message('Debug', 'PHPMailer class is loaded.');
	}
 
    function load(){
        // Cargamos la librería desde Composer
        //require_once APPPATH.'vendor/autoload.php';

        // Creamos una nueva instancia
        $mail = new PHPMailer(true);

        // Ajustes de la librería
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output. https://github.com/PHPMailer/PHPMailer/wiki/SMTP-Debugging
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted

        // Retornamos la instancia
        return $mail;
    }
}
