<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseDatos.php'; 

class seguimientoMedicoController {

    
    public static function obtenerSeguimientosPorResidenteId($residente_id) {
        try {
            $db = AbrirBDMongo();
            $coleccionSeguimientos = $db->seguimientos_medicos;

            $options = ['sort' => ['fecha' => -1]];
            $seguimientos = $coleccionSeguimientos->find(['residente_id' => $residente_id], $options);

            return iterator_to_array($seguimientos);
        } catch (Exception $e) {
            error_log("Error al obtener seguimientos médicos: " . $e->getMessage());
            return [];
        }
    }

    
    public static function agregarSeguimiento(array $datos) {
        try {
            $db = AbrirBDMongo();
            // Asignamos un ID de texto simple y único.
            if (!isset($datos['_id'])) {
                $datos['_id'] = uniqid('seguimiento_');
            }
            $coleccionSeguimientos = $db->seguimientos_medicos;
            $coleccionSeguimientos->insertOne($datos);
            return true;
        } catch (Exception $e) {
            error_log("Error al agregar seguimiento médico: " . $e->getMessage());
            return false;
        }
    }
 
    public static function eliminarSeguimiento($seguimiento_id) {
        // Lógica de eliminación directa sin usar ObjectId
        try {
            $db = AbrirBDMongo();
            $coleccionSeguimientos = $db->seguimientos_medicos;
            // Buscamos el _id como un string, que es como lo guardamos ahora.
            $resultado = $coleccionSeguimientos->deleteOne(['_id' => $seguimiento_id]);
            return $resultado->getDeletedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar seguimiento médico: " . $e->getMessage());
            return false;
        }
    }
}
?>