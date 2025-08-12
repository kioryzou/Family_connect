<?php
require_once __DIR__ . '/../vendor/autoload.php';

class familiarController {

    public static function obtenerFamiliares() {
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionFamiliares = $baseDatos->familiares;
            return $coleccionFamiliares->find()->toArray();
        } catch (Exception $e) {
            echo "Error al obtener familiares: " . $e->getMessage();
            return [];
        }
    }

    public static function obtenerFamiliarPorId($familiar_id){
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionFamiliares = $baseDatos->familiares;

            $familiar = $coleccionFamiliares->findOne(['_id' => $familiar_id]);

            if ($familiar) {
                return $familiar;
            }
            return null;
        } catch (Exception $e) {
            echo "Error al obtener familiar: " . $e->getMessage();
            return null;
        }
    }

    public static function agregarFamiliar($data) {
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionFamiliares = $baseDatos->familiares;

            return $coleccionFamiliares->insertOne($data);
        } catch (Exception $e) {
            echo "Error al agregar familiar: " . $e->getMessage();
            return null;
        }
    }

    public static function editarFamiliar($id, $data) {
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionFamiliares = $baseDatos->familiares;

            $filtro = ['_id' => $id];
            return $coleccionFamiliares->updateOne($filtro, ['$set' => $data]);
        } catch (Exception $e) {
            echo "Error al editar familiar: " . $e->getMessage();
            return null;
        }
    }

    public static function eliminarFamiliar($id) {
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionFamiliares = $baseDatos->familiares;

            $filtro = ['_id' => $id];
            return $coleccionFamiliares->deleteOne($filtro);
        } catch (Exception $e) {
            echo "Error al eliminar familiar: " . $e->getMessage();
            return null;
        }
    }
}
?>