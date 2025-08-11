<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseDatos.php'; 

class medicamentoController {

    
    public static function obtenerMedicamentoPorId($id) {
        try {
            $db = AbrirBDMongo();
            $coleccionMedicamentos = $db->medicamentos;
            $medicamento = $coleccionMedicamentos->findOne(['_id' => $id]);
            return $medicamento;
        } catch (Exception $e) {
            error_log("Error al obtener medicamento por ID: " . $e->getMessage());
            return null;
        }
    }

   
    public static function obtenerMedicamentosPorResidenteId($residente_id) {
        try {
            $db = AbrirBDMongo();
            $coleccionMedicamentos = $db->medicamentos;
            $medicamentos = $coleccionMedicamentos->find(['residente_id' => $residente_id]);
            return iterator_to_array($medicamentos);
        } catch (Exception $e) {
            error_log("Error al obtener medicamentos: " . $e->getMessage());
            return [];
        }
    }

    
    public static function agregarMedicamento(array $datos) {
        try {
            $db = AbrirBDMongo();
            $coleccionMedicamentos = $db->medicamentos;
            if (!isset($datos['_id'])) {
                $datos['_id'] = uniqid('med_');
            }
            $coleccionMedicamentos->insertOne($datos);
            return true;
        } catch (Exception $e) {
            error_log("Error al agregar medicamento: " . $e->getMessage());
            return false;
        }
    }

   
    public static function editarMedicamento($id, array $datos) {
        try {
            $db = AbrirBDMongo();
            $coleccionMedicamentos = $db->medicamentos;
            $resultado = $coleccionMedicamentos->updateOne(
                ['_id' => $id],
                ['$set' => $datos]
            );
            return $resultado->getModifiedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al editar medicamento: " . $e->getMessage());
            return false;
        }
    }

    
    public static function eliminarMedicamento($id) {
        try {
            $db = AbrirBDMongo();
            $coleccionMedicamentos = $db->medicamentos;
            $resultado = $coleccionMedicamentos->deleteOne(['_id' => $id]);
            return $resultado->getDeletedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar medicamento: " . $e->getMessage());
            return false;
        }
    }
}
?>
