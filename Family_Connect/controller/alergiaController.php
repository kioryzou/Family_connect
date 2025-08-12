<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseDatos.php'; 

class alergiaController {

    
    public static function obtenerAlergiasPorResidenteId($residente_id) {
        try {
            $db = AbrirBDMongo();
            $coleccionAlergias = $db->alergias; 

            $alergias = $coleccionAlergias->find(['residente_id' => $residente_id]);

            return iterator_to_array($alergias);
        } catch (Exception $e) {
            error_log("Error al obtener alergias: " . $e->getMessage());
            return [];
        }
    }

    
    public static function agregarAlergia(array $datos) {
        try {
            $db = AbrirBDMongo();
            if (!isset($datos['_id'])) {
                $datos['_id'] = uniqid('alergia_');
            }
            $coleccionAlergias = $db->alergias;
            $coleccionAlergias->insertOne($datos);
            return true;
        } catch (Exception $e) {
            error_log("Error al agregar alergia: " . $e->getMessage());
            return false;
        }
    }
    
    public static function eliminarAlergia($alergia_id) {
        try {
            $db = AbrirBDMongo();
            $coleccionAlergias = $db->alergias;
            $resultado = $coleccionAlergias->deleteOne(['_id' => $alergia_id]);
            return $resultado->getDeletedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar alergia: " . $e->getMessage());
            return false;
        }
    }
}
?>