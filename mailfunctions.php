<?php

function ppt_mailer($to,$file){

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'Mail/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages

//$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
//$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'mailserver';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587; //995 and 465 port tried but not working

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tsl';//only ssl tried not working

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "email@email";

//Password to use for SMTP authentication
$mail->Password = "ur password";

//Set who the message is to be sent from
$mail->setFrom('', 'Winston');


//Set who the message is to be sent to
$mail->addAddress($to, 'Winston');

//Set the subject line
$mail->Subject = 'Lyric2ppt';



$mail->msgHTML(file_get_contents('Mail/examples/contents.html'), dirname(__FILE__));

$mail->AltBody = 'This is a plain-text message body';

$mail->addAttachment($file);

/*send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}*/

}









?>