<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  </head>
<body style="color: #1c5d79">
	<?php 
	// Capturamo los datos
	$torneo     =   $datos['torneo'];
	$partidos   =   $datos['partidos'];
    $conf       =   $datos['conf'];

    // Capturamos path de los logos
    $logo       = FCPATH. 'assets/uploads/logos/' . $conf->conf_logo;

    // Si no existe el logo del Usuario, mostramos el default
    if( read_file($logo) == FALSE ){
        $logo       = FCPATH. 'assets/img/logos/logo.png';
    }

	?>
    <div class="container-fluid">
        <table cellspacing="0" width="100%">
            <tr>
                <td>
                    <img src="<?php echo $logo; ?>" width="200px">
                </td>
            </tr>
        </table>
        
        
    </div><!-- ./container -->
 
  </body>
</html>

