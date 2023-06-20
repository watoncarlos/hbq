<?php

class Bancos {
    private $conexion;

    public $id;
    public $uid;
    public $account_number;
    public $iban;
    public $bank_name;
    public $routing_number;
    public $swift_bic;
    public $fecha_ingreso;
    public $fecha_modificacion;
    
    public function __construct($id, $uid, $account_number, $iban, $bank_name, $routing_number, $swift_bic, $fecha_ingreso, $fecha_modificacion) {
        $this->id = $id;
        $this->uid = $uid;
        $this->account_number = $account_number;
        $this->iban = $iban;
        $this->bank_name = $bank_name;
        $this->routing_number = $routing_number;
        $this->swift_bic = $swift_bic;
        $this->fecha_ingreso = $fecha_ingreso;
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function obtener_registros($uid) {
        $salida = "";

        $consulta = "SELECT * FROM bancos WHERE uid = '".$uid."'";

        // Ejecutar la consulta
        $resultado = $conexion->ejecutarConsulta($consulta);

        // Verificar si hay resultados
        if ($resultado && $resultado->rowCount() > 0) {
            // Recorrer los resultados
            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
               $salida = "El resultado es: ".$fila['id'] . ' - ' . $fila['uid'] . ' - ' . $fila['account_number'] . ' - ' . $fila['iban'] . ' - ' . $fila['bank_name'] . ' - ' . $fila['routing_number'] . ' - ' . $fila['siwft_bic'];
            
               $retorno = array(
                'success' => true, 
                'salida'  => $salida
                );
            
                return Response()->json($retorno, 200);
            }
        } else {
            $salida =  'No se encontraron resultados.';

            $retorno = array(
                'success' => false, 
                'salida'  => $salida
                );
            
            return Response()->json($retorno, 200);
        }
    }
    
    public function ingresar_registro($id, $uid, $account_number, $iban, $bank_name, $routing_number, $swift_bic, $fecha_ingreso) {
        $consulta = "INSERT INTO bancos (id, uid, account_number, iban, bank_name, routing_number, swift_bic, fecha_ingreso) VALUES (".$id.", '".$uid."', '".$account_number."', '".$iban."', '".$bank_name."', '".$routing_number."', '".$swift_bic."', '".$fecha_ingreso."')";
        
        if($resultado = $conexion->ejecutarConsulta($consulta)){

            $retorno = array(
                'success' => true, 
                'salida'  => "Registro ingresado correctamente"
                );
            
            return Response()->json($retorno, 200);
        }else{
            $retorno = array(
                'success' => false, 
                'salida'  => "Registro no ingresado, reintente"
                );
            
            return Response()->json($retorno, 200);
        }
    }
    
    public function modificar_registro($id, $nuevo_nombre, $fecha_modificacion) {
        $consulta = "UPDATE bancos SET bank_name = '".$nuevo_nombre."', fecha_modificacion = '".$fecha_modificacion."' WHERE id = ".$id."";

        if($resultado = $conexion->ejecutarConsulta($consulta)){

            $retorno = array(
                'success' => true, 
                'salida'  => "Registro modificado correctamente"
                );
            
            return Response()->json($retorno, 200);
        }else{
            $retorno = array(
                'success' => false, 
                'salida'  => "Registro no modificado, reintente"
                );
            
            return Response()->json($retorno, 200);
        }
    }
}


?>