<?php
error_reporting(E_ALL);

require_once 'conectarSqlite.php';
require_once 'bancos.php';

$rutaBaseDatos = '/Users/carlossoto/hbq.db';
$conexion = new ConexionSQLite($rutaBaseDatos);

$banco_nuevo = new Bancos();

$fecha_actual = date("d/m/Y",strtotime(now()));

$curl = curl_init();
// Muestra toda la información, por defecto INFO_ALL

$api_url = "https://random-data-api.com/api/bank/random_bank?size=100";

curl_setopt_array($curl, array(
             CURLOPT_URL => $api_url,
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => '',
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => 'GET',
         )
     );

$response = curl_exec($curl);

//Capturar error de la solicitud HTTP
if($errno = curl_errno($curl)){
    $error_text = curl_error($curl);
    print_r($fecha_actual."ERROR : ".$error_text."\n");
    curl_close($curl);
    return false;
}

curl_close($curl);

if($datos = json_decode($response, true)){
 
    foreach ($datos as $banco) {

        $consulta = "INSERT INTO bancos (id, uid, account_number, iban, bank_name, routing_number, swift_bic, fecha_ingreso) VALUES (".$banco['id'].", '".$banco['uid']."', '".$banco['account_number']."', '".$banco['iban']."', '".$banco['bank_name']."', '".$banco['routing_number']."', '".$banco['swift_bic']."', '".$fecha_actual."')";
        
        $resultado = $conexion->ejecutarConsulta($consulta);
    }

}

$id_buscar = "1";
$id_modificar = "1";
$nuevo_nombre = "Banco Estado";
$fecha_modificacion = $fecha_actual;

$nuevo_id = 2;
$nuevo_uid = "1213213_asdasda";
$nuevo_account_number = "12311";
$nuevo_iban = "222222";
$nuevo_bank_name = "BANCO SANTANDER";
$nuevo_routing_number = "2222";
$nuevo_swift_bic = "21212";
$nuevo_fecha_ingreso = $fecha_actual;


$banco_nuevo->obtener_registros($id_buscar);
$banco_nuevo->ingresar_registro($nuevo_id,$nuevo_uid, $nuevo_account_number, $nuevo_iban, $nuevo_bank_name, $nuevo_routing_number, $nuevo_swift_bic, $nuevo_fecha_ingreso);
$banco_nuevo->modificar_registro($id_modificar, $nuevo_nombre, $fecha_modificacion);


$conexion->cerrarConexion();




?>