<?php
// phpinfo();

require 'lib/PHPMailer-master/PHPMailerAutoload.php';

$mail = new PHPMailer;

// print_r($_GET);
$name = $_GET["firstname"];
$lname = $_GET["lastname"];
$email = $_GET["email"];

// var_dump ($mail);

$mail->SMTPDebug = 0;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'tautvydascoding2@gmail.com';                 // SMTP username
$mail->Password = 'tipologija';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
//
$mail->setFrom('tautvydascoding2@gmail.com', 'Administratorius');
$mail->addAddress($email,  "Vardas: $name $lname" );     // Add a recipient
$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('tautvydascoding2@gmail.com', 'Klausimas');
$mail->addCC('cc@cc.com');
$mail->addBCC('bcc@cc.com');
//
// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
//
$mail->Subject = 'Klausimas del pietu';
$mail->Body    = '<table> \
<th> Ko noreciau valgyti </th> \
<tr>  \
  <td>Medus</td> \
  <td>Grietine</td> \
  <td>Braskiu dzemas</td> \
</tr> \
</table> <b>Pasiraso Myke</b>';
$mail->AltBody = ' Ko noreciau valgyti :  Medus, Grietine, Braskiu dzemas ';

if(!$mail->send()) {
    echo 'Email nepavyko isiusti. Prasome bandyti dar karta';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Laiskas isiustas';
}

?>
