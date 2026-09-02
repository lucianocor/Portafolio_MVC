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
            $mail->addReplyTo($email, $nombre . ' ' . $apellido);

            $mail->isHTML(true);
            $mail->Subject = 'Nuevo mensaje desde el portfolio';
            
            // Todo saneado contra inyecciones HTML
            $nombreSafe   = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
            $apellidoSafe = htmlspecialchars($apellido, ENT_QUOTES, 'UTF-8');
            $emailSafe    = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $msg1Safe     = nl2br(htmlspecialchars($mensaje1, ENT_QUOTES, 'UTF-8'));
            $msg2Safe     = nl2br(htmlspecialchars($mensaje2, ENT_QUOTES, 'UTF-8'));

            $mail->Body = "
                <h2>Nuevo mensaje recibido</h2>
                <p><strong>Remitente:</strong> {$nombreSafe} {$apellidoSafe}</p>
                <p><strong>Email:</strong> {$emailSafe}</p>
                <p><strong>Mensaje:</strong><br>{$msg1Safe}</p>
                " . ($mensaje2 ? "<p><strong>Adicional:</strong><br>{$msg2Safe}</p>" : "");

            $mail->send();
            header('Location: index.php?estado=enviado#formulario');
            exit;

        } catch (Exception $e) {
            // En producción nunca imprimas $mail->ErrorInfo directo al usuario, loguealo.
            error_log("Error PHPMailer: " . $mail->ErrorInfo);
            header('Location: index.php?error=fallo_envio#formulario');
            exit;
        }
    }
}