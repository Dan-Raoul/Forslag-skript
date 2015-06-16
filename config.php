<?php
// Ikkje rør med mindre du veit kva du gjer.
// Inkluder satte variablar og funksjonar
include_once("variablar.php");
include_once("functions.php");

// Startar med å sjekke at det er fylt ut variablar
if (empty($mottaker) || empty($mottaker_namn) || empty($passord) || empty($tittel) || empty($kontaktperson) || empty($baseurl) || empty($saksliste_brukes) || empty($saksliste) || empty($dbserver) || empty($dbbrukar) || empty($dbpassord) || empty($dbnamn)) {
	die("Du har ikke satt variablene. Gjør det før bruk.");
}
elseif ($opent !== TRUE) {
	die("Skjemaet er stengt inntil videre.");
}

if ($_GET["sendt"] == TRUE) {
	// Så sjekkar me at alt er fylt ut, og - viss fylt ut - strippar det, slik at me ikkje hackast.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["sak"])) {
			$sakErr = "Saksnummer er obligatorisk";
		} else {
			$sak = test_input($_POST["sak"]);
			$sakvalt = "Du valgte sak <strong>$sak</strong> i sted. ";
		}
		if (empty($_POST["linje"])) {
			$linjeErr = "Linjenummer er obligatorisk";
		} else {
			$linje = test_input($_POST["linje"]);
		}
		if (empty($_POST["delegat"])) {
			$delegatErr = "Delegatnummer er obligatorisk";
		} else {
			$delegat = test_input($_POST["delegat"]);
		}
		if (empty($_POST["namn"])) {
			$namnErr = "Navn er obligatorisk";
		} else {
			$namn = test_input($_POST["namn"]);
		}
		if (empty($_POST["epost"])) {
			$epostErr = "E-post er obligatorisk";
		} else {
			$epost = test_input($_POST["epost"]);
			// Sjekke e-postadressa
			if (!filter_var($epost, FILTER_VALIDATE_EMAIL)) {
			$epostErr = "Feil e-postformat. "; 
			}
		}
		if (empty($_POST[type])) {
			$typeErr = "Forslagstype er obligatorisk";
		} else {
			$type = test_input($_POST[type]);
		}
		if (empty($_POST["forslag"])) {
			$forslagErr = "Forslagstekst er obligatorisk";
		} else {
			$forslag = test_input($_POST["forslag"]);
		}
		if (empty($_POST["captcha"])) {
			$captchaErr = "Passordet er obligatorisk";
		} elseif (($_POST["captcha"]) == $passord){
			$captcha = test_input($_POST["captcha"]);
		} else {
			$captchaErr = "Passordet er feil. Pr&oslash;v igjen. ";
		}
		if (empty($_POST["kommentar"])) {
			$kommentaren = "<br/>";
		} else {
			$kommentar = test_input($_POST["kommentar"]);
			$kommentaren = '<p>Kommentar: <br/>' . $kommentar . '</p><br/>';
		}
	
		// Gi beskjed viss noko manglar
		if (!empty ($sakErr) || !empty ($linjeErr) || !empty ($delegatErr) || !empty ($namnErr) || !empty ($epostErr) || !empty ($typeErr) || !empty ($captchaErr) || !empty ($forslagErr) || empty ($sak) || empty ($linje) || empty ($delegat) || empty ($namn) || empty ($epost) || empty ($type) || empty ($forslag) || empty ($captcha)) {
			$resultat		=	"Fyll ut skjemaet:";
			$resultat		.=	"<br/><a href='javascript: history.go(-1)'>$sakErr $linjeErr $delegatErr $namnErr $epostErr $typeErr $captchaErr $forslagErr</a>";
			// Feilsøking:
			//$resultat		.= "<br/>Feil (skal være tom): $sakErr $linjeErr $delegatErr $namnErr $epostErr $typeErr $captchaErr $forslagErr <br/>Sendt (skal ikke være tom): Sak: $sak Linje: $linje Delegat: $delegat Navn: $namn E-post: $epost Type: $type Forslag: $forslag Passord: $captcha";
		}
		else {
			// Skrive til databasen
			include 'skrivdb.php';
			if ($dbskrevet === 1) {
				// Formatere e-post
				$to			=	"$mottaker_namn<$mottaker>";
				$cc			=	$epost;
				$subject	=	"Nytt forslag til $tittel-sak $sak";
				$message	=	'
									<html>
										<head>
											<title>' . $subject . '</title>
										</head>
										<body>
											<p>Forslagsnummer (digitalt): ' . $dbid . '</p>
											<p>Saksnummer: ' . $sak . '</p>
											<p>Delegatnummer: ' . $delegat . '</p>
											<p>Navn: ' . $namn . '</p>
											<p>E-post: ' . $epost . '</p>
											<p>Linjenummer: ' . $linje . '</p>
											<p>Forslagstype: ' . $type . '</p>
											<p>Forslagstekst: <br/>' . $forslag . '</p>
											' . $kommentaren . '
											<p>' . $dbtilkopling_status . '</p>
											<p>Sendt fra ' . $ip . ', med nettleser ' . $nettleser . ', og ble referert fra ' . $referent . '</p>
										</body>
									</html>
								';
				$headers	=	"Cc: $epost" . "\r\n" .
								"From: $to" . "\r\n" .
								"Reply-To: $to" . "\r\n" .
								"MIME-Version: 1.0" . "\r\n" .
								"Content-type: text/html; charset=UTF-8" . "\r\n" .
								"X-mailer: PHP/" . phpversion();
				// Sende e-post
				mail($to, $subject, $message, $headers);
				// Gi beskjed om at det er sendt, viss så er tilfelle
				$resultat		=	"Ditt forslag er sendt til $mottaker. Du vil f&aring; kopi til din e-post. Ta kontakt med $kontaktperson hvis dette ikke er tilfellet.";
				$resultattype	=	"sendt";
				$captcha		=	"FEIL";
				// Og sende dei dit dei skal!
				redirect("forslag.php?registrert=$dbid");
			}
			elseif ($dbskrevet === 0) {
				$resultattype	=	"error";
				$resultat		=	"Det skjedde en feil ved skriving til databasen. Prøv igjen. Ved fortsatt feil, ta kontakt med $kontaktperson ($mottaker).<br/>Feilkode:<br/>$dbtilkopling_status";
			}
			else {
				$resultattype	=	"error";
				$resultat		=	"Det har skjedd en ukjent feil. Prøv igjen. Ved fortsatt feil, ta kontakt med $kontaktperson ($mottaker).<br/>Feilkode:<br/>$dbtilkopling_status";
			}
		}
	}
}
elseif (!empty($_GET["registrert"])) {
	$resultat		=	"Ditt forslag er sendt til $mottaker. Du vil f&aring; kopi til din e-post. Ta kontakt med $kontaktperson hvis dette ikke er tilfellet.";
	$resultattype	=	"sendt";
}
?>