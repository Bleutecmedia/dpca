<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:        Hook site offline
 * Author:      Rigoberto Alejandres
 * Email:       isc.alej@gmail.com
 * Twitter:     @iscalej
 * Created:     13.10.2019
 * Description: Hook que permite poner el sitio completammente offline desde el config.
 **/

class Site_Offline {

    function __construct() {

    }

    public function is_offline() {
        if (file_exists(APPPATH . 'config/config.php')) {
            include(APPPATH . 'config/config.php');

            if (isset($config['is_offline']) && $config['is_offline'] === TRUE) {
                $this->show_site_offline();
                exit;
            }
        }
    }

    private function show_site_offline() {
        echo '<html><body><span style="color:red;"><strong>El sitio está fuera de línea debido a mantenimiento. Volveremos pronto. Por favor, vuelva más tarde</strong></span>.</body></html>';
    }

}

/* End of file site_offline.php */
/* Location: ./application/hooks/site_offline.php */