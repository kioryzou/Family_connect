<?php 
require_once __DIR__ . '/../vendor/autoload.php';

class loginController {

    public static function buscarPorId($user_id){
        try{
             $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $baseDatos = $cliente->Hoga;

            $familiares = $baseDatos->familiares;
            $usuarios = $baseDatos->usuarios;

            $familiar = $familiares->findOne(['_id' => $user_id]);
            if($familiar) {
                $familiar['tipo'] = 'familiar';
                return $familiar;
            }
            $usuario = $usuarios->findOne(['_id' => $user_id]);
            if($usuario){
                $usuario['tipo'] = 'usuario';
                return $usuario;
            }

            return null;
        }catch (Exception $e){
           error_log("Error de ID". $e->getMessage());
           return null;
        }
        }

        public static function procesarLogin(){
         if(session_status() === PHP_SESSION_NONE){
            session_start();
         }
         if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user_id = $_POST['user_id'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $usuario = self::buscarPorId($user_id);


        
           if($usuario && $contrasena === $usuario['clave']){
           
                $_SESSION['user_id']= (string) $usuario['_id']; 
                $_SESSION['user_nombre'] = $usuario['nombre'];
                
               
                if ($usuario['tipo'] === 'familiar') {
                    $_SESSION['role'] = 'familiar';
                    $_SESSION['residente_id'] = (string) $usuario['residente_id'];
                } else {
                   
                    $_SESSION['role'] = $usuario['rol'] ?? 'cuidador'; 
                }

                header("Location: index.php");
                exit();
            }
          
         }
      return false;
    }
}
?>   