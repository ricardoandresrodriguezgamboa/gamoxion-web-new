<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (isset($_POST['g-recaptcha-response'])) {
        $token = $_POST['g-recaptcha-response'];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => '6LeI2MArAAAAAKmVGy1ZqFYklHWSxQQJXj98rgM9',
            'response' => $token
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result);

        // Verificar éxito, score y acción
        if ($response->success && $response->score >= 0.5 && $response->action === 'submit') {

            try {
                // Escapar inputs para mayor seguridad
                $nombre   = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
                $telefono = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
                $email    = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
                $mensaje  = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
                $asunto   = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');

                // Validar que no estén vacíos
                if (!empty($nombre) && !empty($telefono) && !empty($email) && !empty($mensaje) && !empty($asunto)) {

                    // Configuración PHPMailer
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'mail.gamoxion.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'contacto@gamoxion.com';
                    $mail->Password = 'B)PMS!o$6uE,v1ZA';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    // Remitente y destinatarios
                    $mail->setFrom('contacto@gamoxion.com', 'Gamoxion');
                    $mail->addAddress('contacto@gamoxion.com');
                    $mail->addAddress('ricardoandres749@gmail.com');
                    $mail->addAddress('pablorodrigueza@hotmail.cl');

                    // Contenido del email
                    $contenido = "<b>Detalles del Contacto:</b><br><br>
                                  <b>Nombre:</b> $nombre<br>
                                  <b>Teléfono:</b> $telefono<br>
                                  <b>Correo:</b> $email<br>
                                  <b>Asunto:</b> $asunto<br>
                                  <b>Mensaje:</b> $mensaje.";

                    $contenidosinhtml = "Detalles del Contacto. Nombre: $nombre, Teléfono: $telefono, Correo: $email, Asunto: $asunto, Mensaje: $mensaje.";

                    $mail->isHTML(true);
                    $mail->Subject = "Contacto Gamoxion - $asunto - $nombre";
                    $mail->Body    = $contenido;
                    $mail->AltBody = $contenidosinhtml;
                    $mail->CharSet = 'UTF-8';

                    $mail->send();

                    echo "<script type='text/javascript'>
                            alert('Gracias por contactarnos, le responderemos a la brevedad.');
                            location.replace(document.referrer);
                          </script>";

                } else {
                    echo "<script type='text/javascript'>
                            alert('Debe completar todos los campos del formulario.');
                            location.replace('http://gamoxion.com/#contacto');
                          </script>";
                }

            } catch (Exception $e) {
                echo "<script type='text/javascript'>
                        alert('Ha ocurrido un error al enviar el mensaje. Intente más tarde.');
                        location.replace(document.referrer);
                      </script>";
            }

        } else {
            // Si falla reCAPTCHA
            echo "<script type='text/javascript'>
                    alert('No se pudo verificar que seas humano. Intenta de nuevo.');
                    location.replace(document.referrer);
                  </script>";
        }
    } else {
        // Si no hay token
        echo "<script type='text/javascript'>
                alert('No se recibió el token de reCAPTCHA.');
                location.replace(document.referrer);
              </script>";
    }
}
?>
