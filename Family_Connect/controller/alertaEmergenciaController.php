<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseDatos.php'; 

class alertaEmergenciaController {

    private static $collectionName = 'alerta_Emergencias';


    public static function obtenerTodasLasAlertas() {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $cursor = $collection->find([], ['sort' => ['fecha' => -1]]);
            return iterator_to_array($cursor);
        } catch (Exception $e) {
            error_log("Error al obtener todas las alertas de emergencia: " . $e->getMessage());
            return [];
        }
    }


    public static function obtenerAlertasPorResidenteId($residente_id) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $cursor = $collection->find(['residente_id' => $residente_id], ['sort' => ['fecha' => -1]]);
            return iterator_to_array($cursor);
        } catch (Exception $e) {
            error_log("Error al obtener alertas de emergencia por residente ID: " . $e->getMessage());
            return [];
        }
    }

    public static function agregarAlerta(array $datos) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $collection->insertOne($datos);
            return true;
        } catch (Exception $e) {
            error_log("Error al agregar alerta de emergencia: " . $e->getMessage());
            return false;
        }
    }


    public static function editarAlerta($id, array $datos) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $resultado = $collection->updateOne(
                ['_id' => $id],
                ['$set' => $datos]
            );
            return $resultado->getModifiedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al editar alerta de emergencia: " . $e->getMessage());
            return false;
        }
    }

 
    public static function eliminarAlerta($id) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $resultado = $collection->deleteOne(['_id' => $id]);
            return $resultado->getDeletedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar alerta de emergencia: " . $e->getMessage());
            return false;
        }
    }
}
?>