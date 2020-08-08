<?php

/**
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	Programa de Escuelas de Tiempo Completo
 * @author	I.S.C. Rigoberto Alejandres García <isc.alej@gmail.com>
 * @license	https://github.com/Iscalej/petc/blob/master/license.txt	MIT License
 * @link	https://github.com/Iscalej/petc
 * @since	Version 1.0.0
 * @filesource fechanice_helper
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Función para retornar el valor de un elemento de una tabla en base al ID
 *
 * @param string $table => Nombre de la tabla, ejemplo: 'dir_municipios'
 * @param string $field => Nombre del campo a retornar valor, ejemplo: 'mun_nombre'
 * @param string $key   => Primary key de la tabla, ejemplo: 'munid'
 * @param string $id    => Valor del ID del elemento de la tabla, ejemplo: '255'
 * @return string con el valor solicitado, ejemplo: 'Villa de Álvarez'
 */
function nombre_nice($table = "", $field = "", $key = "", $id = "")
{
    // Una query en un helper, pero qué coño!! 

    // Cargamos la instancia global de Codeigniter
    $ci = &get_instance();

    // Obtenemos el resultado
    $q  =   $ci
        ->sqlite
        ->select("$field")
        ->from($table)
        ->where($table . '.' . $key, $id)
        ->get();

    // Si hay datos, retornamos el campo solicitado
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $row) {
            return $row->$field;
        }
    }

    // Si no hay datos, retiurnamos N/A
    return 'N/A';
} //End nombre_nice($table="",$field="",$key="",$id="")


/**
 * Función para retornar una fecha tipo '2020-02-25' a '25 de febrero de 2020'
 *
 * @param string $fecha con la fecha a pasar a chida
 * @return string con la fecha chida
 *
 */
function fecha_nice($fecha = "")
{

    // todo - validar que la fecha ingresada sea correcta

    // Array para seleccionar el mes 
    $meses    = array(
        '01'    =>  'enero',
        '02'    =>  'febrero',
        '03'    =>  'marzo',
        '04'    =>  'abril',
        '05'    =>  'mayo',
        '06'    =>  'junio',
        '07'    =>  'julio',
        '08'    =>  'agosto',
        '09'    =>  'septiembre',
        '10'    =>  'octubre',
        '11'      =>  'noviembre',
        '12'    =>  'diciembre'
    );

    // Quitamos el '-' y pasamos a array los elementos
    $fecha_re   =   explode('-', $fecha);

    // Constuimos el label
    $label     =   $fecha_re[2] . ' de ' . $meses[$fecha_re[1]] . ' de ' . $fecha_re[0];

    // Retornamos el nombre chido de la fecha
    return $label;
} // End fecha_nice($fecha="")

/**
 * Función para retornar el nombre del mes en base a su número
 *
 * @param int $number número del mes, ejemplo: 03
 * @return string el nombre del mes, ejemplo: Marzo
 */
function number_to_mes($number = "")
{
    $meses    = array(
        '01'    =>  'enero',
        '02'    =>  'febrero',
        '03'    =>  'marzo',
        '04'    =>  'abril',
        '05'    =>  'mayo',
        '06'    =>  'junio',
        '07'    =>  'julio',
        '08'    =>  'agosto',
        '09'    =>  'septiembre',
        '10'    =>  'octubre',
        '11'    =>  'noviembre',
        '12'    =>  'diciembre'
    );

    return $meses[str_pad($number, 2, 0, STR_PAD_LEFT)];
} // End number_to_mes()


/**
 * Función para generar cadenas aleatorias de 'n' tamaño para la aplicación
 *
 * @param int $len tamaño de la cadena a generar
 * @return string aleatorio con el tamano especificado
 */

function str_gen($len = 10)
{
    $token = '';
    $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

    for ($i = 0; $i < $len; $i++) {
        $token .= $keys[array_rand($keys)];
    }

    return $token;
} // End str_gen


/** 
 * Genera una cadena aleatoria en base a MD5
 *
 * @param int $len tamaño de la cadena a generar
 * @return string aleatorio con el tamano especificado
 */
function md5_gen($len = 10)
{
    return substr(md5(uniqid(rand(), true)), 0, $len);
} // End md5_gen


/** 
 * Función para retornar una cadena de bytes en base a hexadecimal
 *
 * @param int $len tamaño de la cadena a generar
 * @return string aleatorio con el tamano especificado
 */
function hex_gen($len = 10)
{
    return substr(bin2hex(random_bytes($len)), 0, $len);
} // End hex_gen


/** 
 * Función para retornar una cadena de bytes en base a base 64
 *
 * @param int $len tamaño de la cadena a generar
 * @return string aleatorio con el tamano especificado
 */
function base_gen($len = 10)
{
    return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $len);
} // End base_gen

// End Helper


/**
 * Función para elimiminar elementos vacíos dentro de un array
 *
 * @param array $element Array de elemmentos a eliminar 
 * @return array de elementos correctos
 */
function removeEmptyElements(&$element)
{
    if (is_array($element)) {
        if ($key = key($element)) {
            $element[$key] = array_filter($element);
        }

        if (count($element) != count($element, COUNT_RECURSIVE)) {
            $element = array_filter(current($element), __FUNCTION__);
        }

        $element = array_filter($element);

        return $element;
    } else {
        return empty($element) ? false : $element;
    }
} // End removeEmptyElements



function searchForId($id, $array)
{
    foreach ($array as $key => $val) {
        if ($val['uid'] === $id) {
            return $key;
        }
    }
    return null;
}


/**
*   Función para convertir un número del forato 59874.50 a 59,874.50
 * @author I.S.C. Rigoberto Alejandres <rigol@bleutecedia.com>
 * @param string $cifras La cifra a medir su longitud
*/

function number_nice($val, $symbol = '', $decimals = 0, $miles="," ) {
    $c      =   is_float( $val ) ? 1 : number_format( $val, $decimals );
    $sign   =   ( $val < 0 ) ? '-' : '';
    $i      =   $val = number_format( abs( $val ) ,$decimals ); 
    $j      =   ( ( $j = strlen($i) ) > 3 ) ? $j % 3 : 0;  

    return  $symbol.$sign.($j ? substr( $i,0, $j ) : '').preg_replace( '/(\d{3})(?=\d)/',"$1" . $miles,substr($i,$j) );
}


/**
 * Función para retornar el array con los encuentros del fixture de un total de Equipos dados
 *
 * @param Int $total_equipos => Total de Equipos del cual generar el Fixture
 * @return Array con los encuentros organizados por jornada. Ejemplo, para 4 equipos:
 *  
 *  Array
 *   (
 *      [1] => Array
 *           (
 *               [0] => 2-3
 *               [1] => 1-4
 *           )
 *
 *       [2] => Array
 *           (
 *               [0] => 1-2
 *               [1] => 4-3
 *           )
 *
 *       [3] => Array
 *           (
 *               [0] => 3-1
 *               [1] => 2-4
 *          )
 *
 *  )
 *
 *  Dónde el índice del primer array es el número de jornada y los índices de cada
 *  uno de los arrays internos + 1, es el número de partido de la jornada.
 */
function generar_fixture($total_equipos) {

    // Array para almacenar el fixture
    $partidos   =   array();

    // Si el número de equipos es desproporcionado,
    // retornamos el array vacío y terminamos la ejecución.
    if($total_equipos > 60){
        return $partidos;
        die();
    }

    // ¿Tenemos un número positivo de jugadores? Si no, por defecto es 4.
    $total_equipos = ($total_equipos > 0) ? (int)$total_equipos : 4;

    // Si es necesario, redondea el número de jugadores al número par más cercano.
    $total_equipos += $total_equipos % 2;

    // Genere los emparejamientos para cada ronda.
    for ($round = 1; $round < $total_equipos; $round++) {

        // Array para guardar los Equipos ya usados
        $equipos_done = array();

        // Empareja a cada equipo excepto el último
        for ($equipo = 1; $equipo < $total_equipos; $equipo++) {

            // Si el jugador 
            if (!in_array($equipo, $equipos_done)) {

                // Selecciona oponente
                $opponent = $round - $equipo;
                $opponent += ($opponent < 0) ? $total_equipos : 1;

                // Asegúrate de que el oponente no sea la jugadora actual.
                if ($opponent != $equipo) {
                    // Colores
                    if (($equipo + $opponent) % 2 == 0 xor $equipo < $opponent) {
                        // Blanco
                        $partidos[$round][]   =  $equipo . '-' . $opponent; 
                    } else {
                        // Negro
                        $partidos[$round][]   =  $opponent . '-' . $equipo; 
                    }

                    // Este par de jugadores están listos para esta ronda.
                    $equipos_done[] = $equipo;
                    $equipos_done[] = $opponent;
                }// End if ($opponent != $equipo)
            }// End if (!in_array($equipo, $equipos_done))
        }// End for ($equipo = 1; $equipo < $total_equipos; $equipo++)

        // Empareja la última jornada
        if ($round % 2 == 0) {
            // Generamos el oponente
            $opponent = ($round + $total_equipos) / 2;

            // Último equipo blanco.
            $partidos[$round][]   =  $total_equipos . '-' . $opponent;
        } else {
            // Generamos el oponente
            $opponent = ($round + 1) / 2;

            // Último equipo negro.
            $partidos[$round][]   =  $opponent . '-' . $total_equipos;
        }
    }

    // Retorna el array con los esparejamientos
    return $partidos;
    
}// End generar_fixture


/**
 * @param string $dir /path/for/the/directory/
 * @return bool
 **/
function delete_directory($dir){
    if(is_dir($dir)){
      $files = glob($dir . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
 
      foreach($files as $file){
        delete_directory($file);      
      }
 
      rmdir($dir);
    } 
    elseif(is_file($dir)) 
    {
      unlink($dir);  
    }
}


/**
 * Función del Helper para verificar la conexión a internet
 *
 **/
function cic($sCheckHost = 'www.google.com'){
    return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
}