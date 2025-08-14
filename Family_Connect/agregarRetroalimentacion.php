
<?php
require_once __DIR__ . '/auth_helper.php';
protect_page(['admin', 'doctor', 'enfermero', 'cuidador']); 
 
include('layout.php');
require_once __DIR__ . '/controller/retroalimentacionController.php';

$datos = obtenerRetroalimencacionController::manejarFormulacio();
if(!$datos){
  $datos = [];
 }
?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>FamilyConnect</title>
   <?php IncluirCSS();?>
</head>
    <body>
       <?php MostrarMenu();?>

<main class="container py-5">
    <h2 class="text-center mb-4">Agregar retroalimentacion de Gamificación Cognitiva</h2>
    <form method="POST" action="agregarRetroalimentacion.php" class="mb-5">
     <div class="row">    
     <div class="col-md-6 mb-3 my-4">
    <label for="Residente_id" class="form-label">ID del residente</label>
                                                <input type="text" class="form-control" name="residente_id" required>
                                                
                                            </div>

                                            <div class="col-md-6 mb-3 my-4">
                                                <label for="fecha" class="form-label">Fecha</label>
                                                <input type="date" class="form-control" name="fecha" required>
                                            </div>

                                           <div class="col-md-6 mb-3 my-4">
                                                <label for="actividad" class="form-label">Actividad</label>
                                                <input type="text" class="form-control" name="actividad" required>
                                            </div>

                                           <div class="col-md-6 mb-3 my-4">
                                                <label for="notas" class="form-label">Notas</label>
                                                <textarea class="form-control" name="notas" required></textarea>
                                            </div>

                                            <div class="col-md-6 mb-3 my-4">
                                                <label for="diagnostico" class="form-label">Diagnóstico</label>
                                                <input type="text" class="form-control" name="diagnostico" required>
                                            </div>
                                             <div class="mb-3">
                                                <label for="personal" class="form-label">ID del Personal</label>
                                                <input type="text" class="form-control" name="personal" required>
                                            </div>
                                            <div class="col-md-12 text-center my-4">
                                            <button type="submit" name="enviar_retro" class="btn btn-primary">Agregar</button>
                                            </div> 
                                             </div>    
                                        </form>
                                </main>                                       

            <?php MostrarFooter(); ?>
            <?php IncluirScripts(); ?>
    </body>
</html>
