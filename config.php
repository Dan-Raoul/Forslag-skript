<?php
// Ikkje rør med mindre du veit kva du gjer.
// Inkluder satte variablar og funksjonar
include_once("variablar.php");
include_once("functions.php");

// Startar med å sjekke at det er fylt ut variablar
if (empty($forslag_mottaker) || empty($forslag_mottaker_namn) || empty($forslag_passord) || empty($forslag_tittel) || empty($forslag_kontaktperson) || empty($forslag_baseurl) || empty($forslag_saksliste_brukes) || empty($forslag_saksliste) || empty($forslag_dbserver) || empty($forslag_dbbrukar) || empty($forslag_dbpassord) || empty($forslag_dbnamn)) {
	die("Du har ikke satt variablene. Gjør det før bruk.");
}
elseif ($forslag_opent !== TRUE) {
	die("Skjemaet er stengt inntil videre.");
}

if ($_GET["sendt"] == TRUE) {
	// Så sjekkar me at alt er fylt ut, og - viss fylt ut - strippar det, slik at me ikkje hackast.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["sak"])) {
			$forslag_sakErr = "Saksnummer er obligatorisk";
		} else {
			$forslag_sak = test_input($_POST["sak"]);
			$forslag_sakvalt = "Du valgte sak <strong>$forslag_sak</strong> i sted. ";
		}
		if (empty($_POST["linje"])) {
			$forslag_linjeErr = "Linjenummer er obligatorisk";
		} else {
			$forslag_linje = test_input($_POST["linje"]);
		}
		if (empty($_POST["delegat"])) {
			$forslag_delegatErr = "Delegatnummer er obligatorisk";
		} else {
			$forslag_delegat = test_input($_POST["delegat"]);
		}
		if (empty($_POST["namn"])) {
			$forslag_namnErr = "Navn er obligatorisk";
		} else {
			$forslag_namn = test_input($_POST["namn"]);
		}
		if (empty($_POST["epost"])) {
			$forslag_epostErr = "E-post er obligatorisk";
		} else {
			$forslag_epost = test_input($_POST["epost"]);
			// Sjekke e-postadressa
			if (!filter_var($forslag_epost, FILTER_VALIDATE_EMAIL)) {
			$forslag_epostErr = "Feil e-postformat. "; 
			}
		}
		if (empty($_POST[type])) {
			$forslag_typeErr = "Forslagstype er obligatorisk";
		} else {
			$forslag_type = test_input($_POST[type]);
		}
		if (empty($_POST["forslag"])) {
			$forslag_forslagErr = "Forslagstekst er obligatorisk";
		} else {
			$forslag_forslag = test_input($_POST["forslag"]);
		}
		if (empty($_POST["captcha"])) {
			$forslag_captchaErr = "Passordet er obligatorisk";
		} elseif (($_POST["captcha"]) == $forslag_passord){
			$forslag_captcha = test_input($_POST["captcha"]);
		} else {
			$forslag_captchaErr = "Passordet er feil. Pr&oslash;v igjen. ";
		}
		if (empty($_POST["kommentar"])) {
			$forslag_kommentar = "&nbsp;";
			$forslag_kommentaren = "<br/>";
		} else {
			$forslag_kommentar = test_input($_POST["kommentar"]);
			$forslag_kommentaren = '<p>Kommentar: <br/>' . $forslag_kommentar . '</p><br/>';
		}
	
		// Gi beskjed viss noko manglar
		if (!empty ($forslag_sakErr) || !empty ($forslag_linjeErr) || !empty ($forslag_delegatErr) || !empty ($forslag_namnErr) || !empty ($forslag_epostErr) || !empty ($forslag_typeErr) || !empty ($forslag_captchaErr) || !empty ($forslag_forslagErr) || empty ($forslag_sak) || empty ($forslag_linje) || empty ($forslag_delegat) || empty ($forslag_namn) || empty ($forslag_epost) || empty ($forslag_type) || empty ($forslag_forslag) || empty ($forslag_captcha)) {
			$forslag_resultat		=	"Fyll ut skjemaet:";
			$forslag_resultat		.=	"<br/><a href='javascript: history.go(-1)'>$forslag_sakErr $forslag_linjeErr $forslag_delegatErr $forslag_namnErr $forslag_epostErr $forslag_typeErr $forslag_captchaErr $forslag_forslagErr</a>";
			// Feilsøking:
			//$forslag_resultat		.= "<br/>Feil (skal være tom): $forslag_sakErr $forslag_linjeErr $forslag_delegatErr $forslag_namnErr $forslag_epostErr $forslag_typeErr $forslag_captchaErr $forslag_forslagErr <br/>Sendt (skal ikke være tom): Sak: $forslag_sak Linje: $forslag_linje Delegat: $forslag_delegat Navn: $forslag_namn E-post: $forslag_epost Type: $forslag_type Forslag: $forslag_forslag Passord: $forslag_captcha";
		}
		else {
			// Skrive til databasen
			include 'skrivdb.php';
			if ($forslag_dbskrevet === 1) {
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
				$captcha		=	"FEIL";
				// Og sende dei dit dei skal!
				redirect("forslag.php?registrert=$forslag_dbid");
			}
			elseif ($forslag_dbskrevet === 0) {
				$forslag_resultattype	=	"error";
				$forslag_resultat		=	"Det skjedde en feil ved skriving til databasen. Prøv igjen. Ved fortsatt feil, ta kontakt med $forslag_kontaktperson ($forslag_mottaker).<br/>Feilkode:<br/>$forslag_dbtilkopling_status";
			}
			else {
				$forslag_resultattype	=	"error";
				$forslag_resultat		=	"Det har skjedd en ukjent feil. Prøv igjen. Ved fortsatt feil, ta kontakt med $forslag_kontaktperson ($forslag_mottaker).<br/>Feilkode:<br/>$forslag_dbtilkopling_status";
			}
		}
	}
}
elseif (!empty($_GET["registrert"])) {
	$forslag_resultat		=	"Ditt forslag er sendt til $forslag_mottaker. Du vil f&aring; kopi til din e-post. Ta kontakt med $forslag_kontaktperson hvis dette ikke er tilfellet.";
	$forslag_resultattype	=	"sendt";
}
?>