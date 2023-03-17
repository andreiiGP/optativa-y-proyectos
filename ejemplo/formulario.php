<?php
        
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;
      require 'PHPMailer/src/Exception.php';
      require 'PHPMailer/src/PHPMailer.php';
      require 'PHPMailer/src/SMTP.php';

      $email= isset($_POST['email'])? $_POST['email']:'';
      $mensaje= isset($_POST['mensaje'])? $_POST['mensaje']:'';
      $connect= mysqli_connect ('localhost','brayan','Brayan12345**','formulario');
      $email_error =""; 
      $mensaje_error =""; 
      $errors =""; 
// si la variable fue instanciada 
      if(count($_POST)){

        $errors=0;

        if($_POST['email']=='')
        {
                $email_error='porfavor ingrese un  correo ';
                $errors ++;
        }
        if($_POST['mensaje']=='')
        {
                $email_error='por favor ingrese un mensaje para enviar ';
                $errors ++;
        }
        if($errors== 0)
        {
                $query='INSERT INTO  contact(
                        email,
                        mensaje
                )VALUES("'.addslashes($_POST['email']).'",
                        "'.addslashes($_POST['mensaje']).'"
                
                )';
                mysqli_query($connect,$query);

                $mail = new PHPMailer(true);
try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '16fae3f4d21fca';
        $mail->Password = '33bdda7bc57749';

    #$mail->SMTPOptions = ['ssl'=> ['allow_self_signed' => true]];  // Descomentar si el servidor SMTP tiene un certificado autofirmado
    #$mail->SMTPSecure = false;				// Descomentar si se requiere desactivar cifrado (se suele usar en conjunto con la siguiente línea)
    #$mail->SMTPAutoTLS = false;			// Descomentar si se requiere desactivar completamente TLS (sin cifrado)
 
    $mail->setFrom('remitente@midominio.com');		// Mail del remitente
    $mail->addAddress($email);     // Mail del destinatario
    $mail->isHTML(true);
    $mail->Subject = 'Contacto desde formulario';  // Asunto del mensaje
    $mail->Body    = $mensaje;    // Contenido del mensaje (acepta HTML)
    $mail->AltBody = 'Este es el contenido del mensaje en texto plano';    // Contenido del mensaje alternativo (texto plano)
    $mail->send();
    echo 'El mensaje ha sido enviado';
} catch (Exception $e) {
    echo 'El mensaje no se ha podido enviar, error: ', $mail->ErrorInfo;
}

                header('location: gracias.html');
                die();
        }


      }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formuario php </title>
</head>
<body>

        <h1>formulario de contacto php</h1>

        <form method="post" action="">
        
        Correo electronico:
        <br>
        <input type="text" name="email" value="">
        <?php echo $email_error; ?>
        <br><br>


        mensaje
        <br>
        <textarea name="mensaje"> <?php echo $mensaje_error ; ?> </textarea>
        <?php echo $email_error; ?>
        <br><br>
        <input type="submit" value="submit">
        
        </form>
    
</body>
</html>

