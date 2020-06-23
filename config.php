<?php
// Ikkje rør med mindre du veit kva du gjer.
// Inkluder satte variablar og funksjonar
include_once("variablar.php");
include_once("functions.php");

// Er ting starta eller stengt?
if ($forslag_dbtabell_oppretta !== TRUE) {
	if ($_SERVER["PHP_SELF"]  !== "/start.php") {
		die("Du må gå til start.php for å opprette databasetabellen.");
	}
}
elseif ($forslag_opent !== TRUE) {
	die("Skjemaet er stengt inntil videre.");
}

// Sjekke at det er fylt ut variablar
foreach ($forslag_variablar_satt as $value) { 
	if (!isset($value)) {
		die("Du har ikke satt variablene. Gjør det før bruk.");
	}
	unset ($key);
	unset ($value);
}

if ($_GET["sendt"] == TRUE) {
	// Så sjekkar me at alt er fylt ut, og - viss fylt ut - strippar det, slik at me ikkje hackast.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["sak"])) {
			$forslag_skjemaErr['sak'] = "Saksnummer er obligatorisk";
		} else {
			$forslag_sak = test_input($_POST["sak"]);
			$forslag_sak_nummer = explode("/", $forslag_sak, 2);
			$forslag_sak_nummer_padded = sprintf("%03d", $forslag_sak_nummer[0]);
			$forslag_sak = $forslag_sak_nummer_padded;
			$forslag_sak .= "/";
			$forslag_sak .= $forslag_sak_nummer[1];
			$forslag_sak_format = "/\A\d{3}[\/]" . $forslag_sak_aar . "[a-z]?/i";
			if (!preg_match($forslag_sak_format, $forslag_sak)) {
				$forslag_skjemaErr['sak'] = "Saksnummer er i feil format - det skal være i formatet 05/17a. Du skrev: $forslag_sak";
			}
			$forslag_sakvalt = "Du valgte sak <strong>$forslag_sak</strong> i sted. ";
		}
		if (empty($_POST["linje"])) {
			$forslag_skjemaErr['linje'] = "Linjenummer er obligatorisk";
		} else {
			$forslag_linje = test_input($_POST["linje"]);
		}
		if (empty($_POST["delegat"])) {
			$forslag_skjemaErr['delegat'] = "Delegatnummer er obligatorisk";
		} else {
			$forslag_delegat = test_input($_POST["delegat"]);
		}
		if (empty($_POST["namn"])) {
			$forslag_skjemaErr['namn'] = "Navn er obligatorisk";
		} else {
			$forslag_namn = test_input($_POST["namn"]);
		}
		if (empty($_POST["epost"])) {
			$forslag_skjemaErr['epost'] = "E-post er obligatorisk";
		} else {
			$forslag_epost = test_input($_POST["epost"]);
			$forslag_epost = preg_replace('/\s+/', '', $forslag_epost);
			// Sjekke e-postadressa
			if (!filter_var($forslag_epost, FILTER_VALIDATE_EMAIL)) {
			$forslag_skjemaErr['epost'] = "Feil e-postformat. "; 
			}
		}
		if (empty($_POST[type])) {
			$forslag_skjemaErr['type'] = "Forslagstype er obligatorisk";
		} else {
			$forslag_type = test_input($_POST[type]);
		}
		if (empty($_POST["forslag"])) {
			$forslag_skjemaErr['forslag'] = "Forslagstekst er obligatorisk";
		} else {
			$forslag_forslag = test_input($_POST["forslag"]);
		}
		if (empty($_POST["pass"])) {
			$forslag_skjemaErr['pass'] = "Passordet er obligatorisk";
		} elseif (($_POST["pass"]) == $forslag_passord){
			$forslag_pass = test_input($_POST["pass"]);
		} else {
			$forslag_skjemaErr['pass'] = "Passordet er feil. Pr&oslash;v igjen. ";
		}
		if (empty($_POST["kommentar"])) {
			$forslag_kommentar = "&nbsp;";
			$forslag_kommentaren = "<br/>";
		} else {
			$forslag_kommentar = test_input($_POST["kommentar"]);
			$forslag_kommentaren = '<p>Kommentar: <br/>' . $forslag_kommentar . '</p><br/>';
		}
	
		// Gi beskjed viss noko manglar
		if (isset($forslag_skjemaErr)) {
			$forslag_resultat		=	"<a href='javascript: history.go(-1)'>Fyll ut skjemaet:</a><br/> ";
			foreach($forslag_skjemaErr as $x => $x_value){
				$forslag_resultat	.= $x_value . "<br/>";
			}
		}
		elseif (!isset($forslag_skjemaErr)) {
			// Skrive til databasen
			include 'skrivdb.php';
			if ($forslag_dbskrevet === 1) {
				include 'epost.php';
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
elseif (!empty($_GET["fid"])) {
	$forslag_fid = test_input($_GET["fid"]);
	$forslag_resultat		=	"Ditt forslag <a href='$forslag_baseurl/forslag.php?fid=$forslag_fid'>nr. $forslag_fid</a> er sendt til $forslag_mottaker. Du vil f&aring; kopi til din e-post. Ta kontakt med $forslag_kontaktperson hvis dette ikke er tilfellet.";
	$forslag_resultattype	=	"sendt";
}
?>