<?php
 /*
  // Replace contact@example.com with your real receiving email address
  $receiving_email_address = 'hiura748@gmail.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = 'Online Appointment Form';

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  
  $contact->smtp = array(
    'host' => 'mtp.gmail.com',
    'username' => 'hiura748@gmail.com',
    'password' => 'eolg mkgg izse tgah',
    'port' => '587'
  );
  

  $contact->add_message( $_POST['name'], 'Name');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['phone'], 'Phone');
  $contact->add_message( $_POST['date'], 'Appointment Date');
  //$contact->add_message( $_POST['department'], 'Department');
  //$contact->add_message( $_POST['doctor'], 'Doctor');
  $contact->add_message( $_POST['message'], 'Message');

  echo $contact->send();
?>
*/



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';


$receiving_email_address = 'hiura748@gmail.com';

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hiura748@gmail.com'; 
    $mail->Password   = 'eolg mkgg izse tgah'; 
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

 
    $mail->setFrom($_POST['email'], $_POST['name']);
    $mail->addAddress($receiving_email_address);


    $mail->isHTML(false);
    $mail->Subject = 'Nueva cita desde el formulario web';
    $mail->Body    =
        "Nombre: " . $_POST['name'] . "\n" .
        "Correo: " . $_POST['email'] . "\n" .
        "Teléfono: " . $_POST['phone'] . "\n" .
        "Fecha de cita: " . $_POST['date'] . "\n" .
        "Mensaje: " . $_POST['message'];

  if ($mail->send()) {
    require_once '../controller/visitaController.php';
    // Extraer fecha y hora del campo datetime-local
    $fecha_hora = strtotime($_POST['date']);
    $fecha = date('Y-m-d', $fecha_hora); // formato compatible con input type="date"
    $hora = date('H:i', $fecha_hora);    // formato compatible con input type="time"
    $data = [
      'id' => uniqid('visita_'),
      'residente_id' => $_POST['residente_id'],
      'nombre_visitante' => $_POST['name'],
      'fecha' => $fecha,
      'hora' => $hora,
      'autorizada' => false
    ];
    visitaController::agregarVisita($data);
    echo 'OK';
  } else {
    echo "Mailer Error: {$mail->ErrorInfo}";
  }
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
