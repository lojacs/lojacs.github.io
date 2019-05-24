<?php
  header("Content-Type: application/json");
  header("Access-Control-Allow-Origin: *");  
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require "src/Exception.php";
  require "src/PHPMailer.php";
  require "src/SMTP.php";
  
  $response["status"] = "error";
  $response["message"] = "Formulário vazio.";    
  
  if($_POST) {
    
    $fields["email"]    =  $_POST["email"];
    
    foreach($fields as $field => $value) {
      if(!$value) {
        $response["status"] = "error";
        $response["message"] = "O campo ".$field." é obrigatório.";
        break;
      } else {
        $response["status"] = "success";
      }
    }

    if($response["status"] != "error") {
      
      $message =  "<br/><b>Email</b>: " . $fields["email"];

      $mail = new PHPMailer;
      $mail->isSMTP();
      $mail->setLanguage("pt", "language/phpmailer.lang-pt_br.php");
      $mail->CharSet   = "UTF-8";
      $mail->Host      = 'wmqp-dpxt.accessdomain.com';
      $mail->SMTPAuth  = true;  
      $mail->SMTPSecure = 'tls';
      $mail->Port      = 587; 
      $mail->Username  = "contato@joaofilhosommelier.com.br";
      $mail->Password  = "uF26dC*-vo@";

      $mail->setFrom( $fields["email"] , "Possível Cliente");
      $mail->addAddress("construsede@gmail.com");
      $mail->addAddress("mateusntargino@gmail.com");

      $mail->Subject = "Contato de interese - Construsede";
      $mail->msgHTML($message);

      $mail->DKIM_domain = "construsede.com.br";
      $mail->DKIM_private = "rsa-private.pem"; //path to file on the disk.
      $mail->DKIM_selector = "phpmailer";
      $mail->DKIM_passphrase = "";
      $mail->DKIM_identity = $mail->From;

      if (!$mail->send()) {
        $response["status"] = "error";
        $response["message"] = $mail->ErrorInfo;
      } else {
        $response["status"] = "success";
        $response["message"] = "Seu e-mail foi enviado, em breve entraremos em contato com você, muito obrigado pela atenção!";
      }
    }
  }
  echo json_encode($response);
?>