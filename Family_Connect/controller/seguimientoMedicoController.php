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
}
?>