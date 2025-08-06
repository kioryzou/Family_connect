<?php
require_once __DIR__ . '/../vendor/autoload.php';

class residenteController {

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
        }
     ?>   