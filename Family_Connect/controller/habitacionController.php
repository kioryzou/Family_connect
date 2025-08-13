<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseDatos.php'; 

class habitacionController {

    private static $collectionName = 'habitaciones';

    public static function obtenerHabitaciones() {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $cursor = $collection->find([], ['sort' => ['numero' => 1]]);
            return iterator_to_array($cursor);
        } catch (Exception $e) {
            error_log("Error al obtener habitaciones: " . $e->getMessage());
            return [];
        }
    }

   
    public static function obtenerHabitacionPorId($id) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            return $collection->findOne(['_id' => $id]);
        } catch (Exception $e) {
            error_log("Error al obtener habitación por ID: " . $e->getMessage());
            return null;
        }
    }

    public static function agregarHabitacion(array $datos) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $collection->insertOne($datos);
            return true;
        } catch (Exception $e) {
            error_log("Error al agregar habitación: " . $e->getMessage());
            return false;
        }
    }

    public static function editarHabitacion($id, array $datos) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $resultado = $collection->updateOne(['_id' => $id], ['$set' => $datos]);
            return $resultado->getModifiedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al editar habitación: " . $e->getMessage());
            return false;
        }
    }

    public static function eliminarHabitacion($id) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $resultado = $collection->deleteOne(['_id' => $id]);
            return $resultado->getDeletedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar habitación: " . $e->getMessage());
            return false;
        }
    }
}
?>