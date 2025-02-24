<?php

namespace Lib;

use Error;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Lib\PDF;
use Exception;

class Mail
{
    //Funcion para mandar mail del pedido
    public function mandarMail(array $pedido)
    {

        $mail = new PHPMailer();
        try {
       
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '5c40b816a1b64e';
            $mail->Password = '3b882c184c1894';
            $mail->addAddress($_SESSION['user']['email']);
            $mail->Subject = 'Tu pedido ha sido confirmado';
            $mail->CharSet = 'UTF-8';
       
            //Generar contenido del mail
            $pdf = new PDF();
            $ruta = $pdf->generarPDF();

            $mail->isHTML(true);
            $mail->Body = $_SESSION['user']['nombre'] . ' ha realizado un pedido de tienda';
            $mail->Body .= '<br>Detalles del pedido: <br>';
            $mail->Body .= '<ul>';
            //Muestra el id de usuario, la cantidad de productos, el estado, provincia, localidad y direccion y el precio total
            $mail->Body .= "<li>Usuario: {$_SESSION['user']['nombre']}</li>";   
            $mail->Body .= "<li>Estado: {$pedido['estado']}</li>";
            $mail->Body .= "<li>Provincia: {$pedido['provincia']}</li>";
            $mail->Body .= "<li>Localidad: {$pedido['localidad']}</li>";
            $mail->Body .= "<li>Direccion: {$pedido['direccion']}</li>";
            $mail->Body .= '<ul>';
            
      
            $mail->Body .= '</ul>';
            $mail->Body .= '<br>Por favor, descarga el PDF de tu pedido para ver los productos que has adquirido';
            $mail->Body .= '<br>Gracias por confiar en nosotros';
            $mail->AltBody = 'Tu pedido ha sido confirmado';
            //Añadir archivo PDF
            $mail->addAttachment($ruta);

            //Enviar mail
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
