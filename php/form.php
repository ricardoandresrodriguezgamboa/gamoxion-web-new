<?php
 
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 
 require 'Exception.php';
 require 'PHPMailer.php';
 require 'SMTP.php';
 
 $mail = new PHPMailer(true);                              // Passing `true` enables exceptions


 if($_SERVER['REQUEST_METHOD']=="POST"){

  if(isset($_POST['g-recaptcha-response'])){
      $token = $_POST['g-recaptcha-response'];
      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $data = array(
          'secret' => '6LeI2MArAAAAAKmVGy1ZqFYklHWSxQQJXj98rgM9',
          'response' => $token
      );

      $options = array(
          'http' => array (
              'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
              'method' => 'POST',
              'content' => http_build_query($data)
          )
      );

      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
      $response = json_decode($result);

      /*
      - google response score is between 0.0 to 1.0
      - if score is 0.5, it's a human
      - if score is 0.0, it's a bot
      - google recommend to use score 0.5 for verify human
      */
      if ($response->success && $response->score >= 0.5) {
        


        try {

          $nombre = $_POST['name'];
          $telefono = $_POST['phone'];   
          $email = $_POST['email'];
          $mensaje = $_POST['message'];
          $asunto = $_POST['subject'];

          if (isset($nombre) && !empty($nombre) &&
          isset($telefono) && !empty($telefono) &&
          isset($email) && !empty($email) &&
          isset($mensaje) && !empty($mensaje) &&
          isset($asunto) && !empty($asunto)) {



            
           //Server settings
           $mail->SMTPDebug = 0;                                  // Enable verbose debug output SET TO 0
           $mail->isSMTP();                                      // Set mailer to use SMTP
           $mail->Host = 'mail.gamoxion.com';                   // Specify main and backup SMTP servers
           $mail->SMTPAuth = true;                               // Enable SMTP authentication
           $mail->Username = 'contacto@gamoxion.com';                 // SMTP username
           $mail->Password = 'B)PMS!o$6uE,v1ZA';                           // SMTP password
           $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
           $mail->Port = 465;                                    // TCP port to connect to
       
           //Recipients
       
           //Desde
           $mail->setFrom('contacto@gamoxion.com','Gamoxion');
           
           //Para
        
           $mail->addAddress('contacto@gamoxion.com');     
           
           $mail->addAddress('ricardoandres749@gmail.com'); 
           $mail->addAddress('pablorodrigueza@hotmail.cl'); 
      
          
       
       
      
         $contenido = '<b>Detalles del Contacto. </b> <br><br> <b>Nombre: </b>' .$nombre. '<br> <b>Telefono: </b>' .$telefono. '<br> <b>Correo: </b>'. $email . '<br> <b>Asunto: </b>'. $asunto. '<br> <b>Mensaje: </b>' .$mensaje. '.';
         $contenidosinhtml = 'Detalles del Contacto. Nombre: ' .$nombre. ',Telefono: ' .$telefono. ',Correo: '. $email. ',Asunto:'. $asunto. ',Mensaje:' .$mensaje. '.';
           
           
           //Content
           $mail->isHTML(true);                                  // Set email format to HTML
           $mail->Subject = 'Contacto Gamoxion - ' .$asunto. ' - ' .$nombre. '.';
           $mail->Body    = $contenido;
           $mail->AltBody = $contenidosinhtml;
      
          // Specify UTF-8 encoding
          $mail->CharSet = 'UTF-8';
       
           $mail->send();
           echo "<script type='text/javascript'>alert('Gracias por contactarnos, le responderemos a la brevedad.');location.replace(document.referrer); </script>";

          //  echo '{ "alert": "alert alert-success alert-dismissable", "message": "Your message has been sent successfully!" }';


          }else{
            echo "<script type='text/javascript'>alert('Debe completar todos los campos del formulario.');location.replace('http://gamoxion.com/#contacto');</script>";
          }
      
      
       
      
       } catch (Exception $e) {
            echo "<script type='text/javascript'>alert('Ha ocurrido un error al contactarse, intente mas tarde.');location.replace(document.referrer);</script>";
       }

  
      } else {
          echo json_encode(array('success' => false, "msg"=>"You are a robot!", "response"=>$response));
      }
  }
}




 
 ?>