<?php
require_once __DIR__ . '/../vendor/autoload.php';

class residenteController {


    
    public static function obtenerResidentes() {
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionResidentes = $baseDatos->residentes;
            return $coleccionResidentes->find()->toArray();
        } catch (Exception $e) {
            echo "Error al obtener residentes: " . $e->getMessage();
            return [];
        }
    }



    public static function obtenerResidentePorId($residente_id){
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionResidentes = $baseDatos->residentes;

            
            $residente = $coleccionResidentes->findOne(['_id' => $residente_id]);

           if($residente) {
            return $residente;
            }
            return null;
        
            
        }catch (Exception $e) {
            echo "Error al obtener residente: ".$e->getMessage();
            return null;
        }
    }



    public static function editarResidente($id, $data) {
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionResidentes = $baseDatos->residentes;
            // Permite actualizar tanto por 'id' como por '_id'
            $filtro = ['id' => $id];
            if ($coleccionResidentes->findOne(['_id' => $id])) {
                $filtro = ['_id' => $id];
            }
            return $coleccionResidentes->updateOne($filtro, ['$set' => $data]);
        } catch (Exception $e) {
            echo "Error al editar residente: " . $e->getMessage();
            return null;
        }
    }


    public static function agregarResidente($data) {
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionResidentes = $baseDatos->residentes;

            
            return $coleccionResidentes->insertOne($data);
        } catch (Exception $e) {
            echo "Error al agregar residente: " . $e->getMessage();
            return null;
        }
    }



    public static function eliminarResidente($id) {
        try {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;
            $coleccionResidentes = $baseDatos->residentes;
            
            $filtro = ['id' => $id];
            if ($coleccionResidentes->findOne(['_id' => $id])) {
                $filtro = ['_id' => $id];
            }
            return $coleccionResidentes->deleteOne($filtro);
        } catch (Exception $e) {
            echo "Error al eliminar residente: " . $e->getMessage();
            return null;
        }
    }
}
?>