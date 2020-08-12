<?php defined('BASEPATH') OR exit('No direct script access allowed');
//Sesion
$alum  = $this->session->userdata('alumno');
$cate  = $this->session->userdata('catedratico');
$admi  = $this->session->userdata('administrativo');
$jefe  = $this->session->userdata('administrador');

//Nueva gestión de puestos de un usuario
$idpus  = $this->session->userdata('idpu'); // in_array('8', $idpus) -> Cobranza
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
//Para mostrar la moneda en pesos mexicanos
setlocale(LC_MONETARY, 'es_MX.UTF-8');

/* Variables para mdate */
$f_f1 = "%d/%m/%Y";
$f_f2 = "%d/%m/%Y %h:%i %a";
$f_f3 = "%d/%M/%Y";
$f_f4 = '%A %d de %B de %Y a las %H:%M';

//Variables a usar
$intercambios   =   $pdf_data['intercambios'];
$fechas         =   $pdf_data['fechas'];
$conf           =   $pdf_data['conf'];
$ultimo         =   $pdf_data['ultimo'];

// Fechas del Reporte
$fecha_desde 	=	trim(substr($fechas,0,11));
$fecha_hasta	=	trim(substr($fechas,-11));

$reporte_fecha  =  mb_strtoupper(fecha_nice($fecha_desde) ) . ' AL '. mb_strtoupper(fecha_nice($fecha_hasta));
if($fecha_desde == $fecha_hasta){
    $reporte_fecha  =  mb_strtoupper(fecha_nice($fecha_desde) );
}


// Verificamos si existe el registro inmediato anterior
$peso_anterior  = 0;
if(isset($ultimo) && $ultimo){
    $peso_anterior = $ultimo->in_peso_inicial;
}

// Si hay registros
if(isset($intercambios) && $intercambios){
    ?>

    <div style="text-align: center">
        <h3><?= $conf->conf_paciente ?></h3>
        <h4>REPORTE DEL <?=  $reporte_fecha; ?></h4>
    </div>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th rowspan="2">FECHA</th>
                <th rowspan="2"># Bolsa</th>
                <th rowspan="2">% SOL</th>
                <th colspan="2">HORA SALIDA</th>
                <th colspan="2">HORA SALIDA</th>
                <th colspan="2">PESO (GRAMOS)</th>
                <th colspan="2">BALANCE</th>
                <th rowspan="2">OBSERVACIONES</th>
            </tr>
            <tr>
                <th>EMPIEZA</th>
                <th>TERMINA</th>
                <th>EMPIEZA</th>
                <th>TERMINA</th>
                <th>INICIAL</th>
                <th>FINAL</th>
                <th>DIARIO</th>
                <th>ACUMULADO</th>
            </tr>
        </thead>
        <tbody>
            <?php


            $conteo             = 0; // Llevar el conteo de infusiones al dia
            $peso_acumulado     = 0; // Acumulado de líqquidos

            foreach ($intercambios as $k => $row){
                $conteo += 1;

                // Pesos de la infusion actual
                $peso_inicial = $row->in_peso_inicial;
                $peso_final   = $row->in_peso_final;

                if($peso_anterior == 0){
                    $peso_anterior = $row->in_peso_inicial;
                }

                // Diario individual y peso acumulado
                $peso_diario    = $peso_anterior - $peso_final;
                $peso_acumulado += $peso_diario;

                ?>
                <tr>
                    <td style="text-align: center"><?= date('Y-m-d',$row->in_fecha) ?></td>
                    <td style="text-align: center" width="70px"><?= $conteo ?></td>
                    <td style="text-align: center"><?= $row->sol_concentra ?></td>
                    <td style="text-align: center"><?= date('H:i',$row->in_hora_sale_inicio) ?></td>
                    <td style="text-align: center"><?= date('H:i',$row->in_hora_sale_termina) ?></td>
                    <td style="text-align: center"><?= date('H:i',$row->in_hora_entra_inicio) ?></td>
                    <td style="text-align: center"><?= date('H:i',$row->in_hora_entra_termina) ?></td>

                    <td style="text-align: center"><?= number_nice($row->in_peso_inicial) ?></td>
                    <td style="text-align: center"><?= number_nice($row->in_peso_final) ?></td>
                    <td style="text-align: center"><?= number_nice($peso_diario) ?></td>
                    <td style="text-align: center"><?= number_nice($peso_acumulado) ?></td>
                    <td></td>
                </tr>
                <?php
                if($conteo == $conf->conf_intercambios){
                    $conteo = 0;
                }
            }
            ?>
        </tbody>
    </table>
    <?php
}else{
    echo "No hay datos que mostrar de <b>".$reporte_fecha.'</b>';
}


?>

</body>
</html>