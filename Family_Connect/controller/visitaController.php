<?php
require_once __DIR__ . '/../vendor/autoload.php';

class visitaController {
    public static function obtenerVisitas() {

        $cliente = new MongoDB\Client("mongodb://localhost:27017");
        $baseDatos = $cliente->Hoga;
        $visitas = $baseDatos->visitas;
        return $visitas->find()->toArray();
    }
        public static function agregarVisita($data) {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $visitas = $baseDatos->visitas;
            
            return $visitas->insertOne($data);
        }

        public static function editarVisita($id, $data) {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $visitas = $baseDatos->visitas;
            return $visitas->updateOne(['id' => $id], ['$set' => $data]);
        }

        public static function eliminarVisita($id) {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $visitas = $baseDatos->visitas;
            return $visitas->deleteOne(['id' => $id]);
        }
    
}
?>
