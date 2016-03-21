<?php
	// Formatere e-post
	$forslag_til			=	"$forslag_mottaker_namn<$forslag_mottaker>";
	$forslag_cc			=	$forslag_epost;
	$forslag_emne	=	"Nytt forslag til $forslag_tittel-sak $forslag_sak";
	$forslag_melding	=	'
						<html>
							<head>
								<title>' . $forslag_emne . '</title>
								</head>
							<body>
								<p>Forslagsnummer (digitalt): ' . $forslag_dbid . '</p>
								<p>Saksnummer: ' . $forslag_sak . '</p>
								<p>Delegatnummer: ' . $forslag_delegat . '</p>
								<p>Navn: ' . $forslag_namn . '</p>
								<p>E-post: ' . $forslag_epost . '</p>
								<p>Linjenummer: ' . $forslag_linje . '</p>
								<p>Forslagstype: ' . $forslag_type . '</p>
								<p>Forslagstekst: <br/>' . $forslag_forslag . '</p>
									' . $forslag_kommentaren . '
								<p>' . $forslag_dbtilkopling_status . '</p>
								<p>Sendt fra ' . $forslag_ip . ', med nettleser ' . $forslag_nettleser . ', og ble referert fra ' . $forslag_referent . '</p>
							</body>
						</html>
								';
				$forslag_hoder	=	"Cc: $forslag_epost" . "\r\n" .
								"From: $forslag_til" . "\r\n" .
								"Reply-To: $forslag_til" . "\r\n" .
								"MIME-Version: 1.0" . "\r\n" .
								"Content-type: text/html; charset=UTF-8" . "\r\n" .
								"X-mailer: PHP/" . phpversion();
				// Sende e-post
				mail($forslag_til, $forslag_emne, $forslag_melding, $forslag_hoder);
				// Gi beskjed om at det er sendt, viss så er tilfelle
				$resultat		=	"Ditt forslag er sendt til $forslag_mottaker. Du vil f&aring; kopi til din e-post. Ta kontakt med $forslag_kontaktperson hvis dette ikke er tilfellet.";
				$resultattype	=	"sendt";
				$pass		=	"FEIL";
				// Og sende dei dit dei skal!
				redirect("forslag.php?registrert=$forslag_dbid");
?>