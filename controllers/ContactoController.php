<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

class ContactoController {
    public function enviar() {
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?error=metodo_no_permitido');
            exit;
        }

       
        $nombre   = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $mensaje1 = trim($_POST['mensaje1'] ?? '');
        $mensaje2 = trim($_POST['mensaje2'] ?? '');

        
        if (!$nombre || !$apellido || !$email || !$mensaje1) {
            header('Location: index.php?error=campos_incompletos#formulario');
            exit;
        }

        $mail = new PHPMailer(true);

        try {
           
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = '60bdb0c4926790';
            $mail->Password   = '4d2fdaaca3cb12';
            $mail->Port       = 2525;
            $mail->CharSet    = 'UTF-8';

           
            $mail->setFrom('noreply@tudominio.com', 'Portfolio Contacto');
            $mail->addAddress('admin@tudominio.com');
            $mail->addReplyTo($email, "$nombre $apellido");

            
            $mail->isHTML(true);
            $mail->Subject = 'Nuevo mensaje desde el portfolio';

           
            $cuerpo = "<h2>Nuevo mensaje recibido</h2>";
            $cuerpo .= "<p><strong>Remitente:</strong> " . htmlspecialchars("$nombre $apellido") . "</p>";
            $cuerpo .= "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
            $cuerpo .= "<p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje1)) . "</p>";
            
            if (!empty($mensaje2)) {
                $cuerpo .= "<p><strong>Adicional:</strong><br>" . nl2br(htmlspecialchars($mensaje2)) . "</p>";
            }

            $mail->Body = $cuerpo;

            $mail->send();
            header('Location: index.php?estado=enviado#formulario');
            exit;

        } catch (Exception $e) {
            error_log("Error PHPMailer: " . $mail->ErrorInfo);
            header('Location: index.php?error=fallo_envio#formulario');
            exit;
        }
    }
}