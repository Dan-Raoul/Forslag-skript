<?php
/**
* This example shows making an SMTP connection with authentication.
*/

//SMTP needs accurate times, and the PHP timezone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Europe/Oslo');

require 'PHPMailer-master/PHPMailerAutoload.php';
//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = $forslag_mail_server;
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = $forslag_mail_port;
//Whether to use SMTP authentication
$mail->SMTPAuth = $forslag_mail_auth;
if ($forslag_mail_auth == TRUE) {
	//Username to use for SMTP authentication
	$mail->Username = $forslag_mail_user;
	//Password to use for SMTP authentication
	$mail->Password = $forslag_mail_pass;
}
//Set who the message is to be sent from
$mail->setFrom($forslag_mottaker, $forslag_mottaker_namn);
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($forslag_mottaker, $forslag_mottaker_namn);
$mail->addCC($forslag_epost);
$mail->isHTML(TRUE);

//Set the subject line
$mail->Subject = "Nytt forslag (nr. $forslag_dbid) til $forslag_tittel-sak $forslag_sak";
//if you want to include text in the body. 
$mail->Body    = '
							<html>
								<head>
									<title>' . $forslag_emne . '</title>
									</head>
								<body>
									<p><a href="' . $forslag_baseurl . '/forslag.php?fid=' . $forslag_dbid . '">Forslagsnummer (digitalt): ' . $forslag_dbid . '</a></p>
									<p>Saksnummer: ' . $forslag_sak . '</p>
									<p>Navn: ' . $forslag_namn . '</p>
									<p>E-post: ' . $forslag_epost . '</p>
									<p>Linjenummer: ' . $forslag_linje . '</p>
									<p>Forslagstype: ' . $forslag_type . '</p>
									<p>Forslagstekst: <br/>' . $forslag_forslag . '</p>
										' . $forslag_kommentaren . '
									<p>Forslaget er tilgjengelig her:<br />
									<a href="' . $forslag_baseurl . '/forslag.php?fid=' . $forslag_dbid . '">' . $forslag_baseurl . '/forslag.php?fid=' . $forslag_dbid . '</a></p>
									<p>Sendt ' . $forslag_tid . ' fra ' . $forslag_ip . ', med nettleser ' . $forslag_nettleser . ', og ble referert fra ' . $forslag_referent . '</p>
								</body>
							</html>
							';

//send the message, check for errors
if (!$mail->send()) {
   $resultat = "Mailer Error: " . $mail->ErrorInfo;
   $resultattype = "feil";
   $pass = "FEIL";
} else {
		// Gi beskjed om at det er sendt, viss så er tilfelle
		$resultat		=	"Ditt forslag er sendt til $forslag_mottaker. Du vil f&aring; kopi til din e-post. Ta kontakt med $forslag_kontaktperson hvis dette ikke er tilfellet.";
		$resultattype	=	"sendt";
		$pass		=	"FEIL";
		// Og sende dei dit dei skal!
		redirect("forslag.php?fid=$forslag_dbid");
}
?>