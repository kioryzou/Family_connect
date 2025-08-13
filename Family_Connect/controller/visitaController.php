<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseDatos.php';
use MongoDB\BSON\ObjectId;

class visitaController {
    private static $collectionName = 'visitas';

    public static function obtenerVisitas() {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            return $collection->find([], ['sort' => ['fecha' => -1]])->toArray();
        } catch (Exception $e) {
            error_log("Error al obtener visitas: " . $e->getMessage());
            return [];
        }
    }

    public static function agregarVisita($data) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $resultado = $collection->insertOne($data);
            return $resultado->getInsertedId();
        } catch (Exception $e) {
            error_log("Error al agregar visita: " . $e->getMessage());
            return null;
        }
    }

    public static function editarVisita($id, $data) {
        try {
            $db = AbrirBDMongo();
            $collection = $db->{self::$collectionName};
            $resultado = $collection->updateOne(['_id' => $id], ['$set' => $data]);
            return $resultado->getModifiedCount() > 0;
        } catch (Exception $e) {
            error_log("Error al editar visita: " . $e->getMessage());
            return false;
        }
    }

    public static function eliminarVisita($id) {
        return eliminarDocumentoPorId(self::$collectionName, $id);
    }
}
?>
