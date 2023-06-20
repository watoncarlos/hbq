<?php

class ConexionSQLite {
    private $conexion;

    public function __construct($rutaBaseDatos) {
        try {
            $this->conexion = new PDO('sqlite:' . $rutaBaseDatos);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Error al conectar a la base de datos: ' . $e->getMessage();
        }
    }

    public function ejecutarConsulta($consulta) {
        try {
            return $this->conexion->query($consulta);
        } catch (PDOException $e) {
            echo 'Error al ejecutar la consulta: ' . $e->getMessage().'';
        }
    }

    public function cerrarConexion() {
        $this->conexion = null;
    }
}


?>