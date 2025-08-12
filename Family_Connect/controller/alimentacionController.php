<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseDatos.php'; 

class alimentacionController {

   
    public static function obtenerAlimentacionPorResidenteId($residente_id) {
        try {
            $db = AbrirBDMongo();
            $coleccionAlimentacion = $db->alimentacion; 

            $alimentacion = $coleccionAlimentacion->findOne(['residenteId' => $residente_id]);

            return $alimentacion;
        } catch (Exception $e) {
            error_log("Error al obtener información de alimentación: " . $e->getMessage());
            return null;
        }
    }

    
    public static function guardarOActualizarAlimentacion(array $datos) {
        try {
            $db = AbrirBDMongo();
            $coleccionAlimentacion = $db->alimentacion;

            $residenteId = $datos['residenteId'];
            unset($datos['residenteId']); 

            $resultado = $coleccionAlimentacion->updateOne(
                ['residenteId' => $residenteId],
                ['$set' => $datos],
                ['upsert' => true] 
            );
            return true; 
        } catch (Exception $e) {
            error_log("Error al guardar/actualizar alimentación: " . $e->getMessage());
            return false;
        }
    }
}
?>