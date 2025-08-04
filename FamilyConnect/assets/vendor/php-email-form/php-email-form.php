
<?php
/*
class PHP_Email_Form {
  public $to;
  public $from_name;
  public $from_email;
  public $subject;
  public $message = '';
  public $ajax;

  public function add_message($content, $label) {
    $this->message .= "$label: $content\n";
  }

  public function send() {
    $headers = "From: $this->from_name <$this->from_email>";
    if(mail($this->to, $this->subject, $this->message, $headers)) {
      return 'Message sent successfully!';
    } else {
      return 'Failed to send message.';
    }
  }
}
*/

class PHP_Email_Form {
  public $to;
  public $from_name;
  public $from_email;
  public $subject;
  public $message = '';
  public $smtp = null;

  public function add_message($content, $label) {
    $this->message .= "$label: $content\n";
  }

  public function send() {
    if ($this->smtp) {
      // Enviar con SMTP
      $headers = "From: ".$this->from_name." <".$this->from_email.">\r\n";
      $headers .= "Reply-To: ".$this->from_email."\r\n";
      $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

      $smtp_config = $this->smtp;
      $host = $smtp_config['host'];
      $port = $smtp_config['port'];
      $username = $smtp_config['username'];
      $password = $smtp_config['password'];

      // PHPMailer sería mejor, pero esto es lo mínimo
      require_once(__DIR__ . '/PHPMailer/PHPMailer.php');
      require_once(__DIR__ . '/PHPMailer/SMTP.php');
      require_once(__DIR__ . '/PHPMailer/Exception.php');

      $mail = new PHPMailer\PHPMailer\PHPMailer(true);
      try {
        $mail->isSMTP();
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $port;

        $mail->setFrom($this->from_email, $this->from_name);
        $mail->addAddress($this->to);
        $mail->Subject = $this->subject;
        $mail->Body    = $this->message;

        $mail->send();
        return 'OK';
      } catch (Exception $e) {
        return 'Mailer Error: ' . $mail->ErrorInfo;
      }

    } else {
      // Método antiguo (no recomendado)
      $headers = "From: $this->from_name <$this->from_email>";
      return mail($this->to, $this->subject, $this->message, $headers) ? 'OK' : 'Failed to send message.';
    }
  }
}
