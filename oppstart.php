<?php
if ($_GET["start"] == TRUE) {
	// Så sjekkar me at alt er fylt ut, og - viss fylt ut - strippar det, slik at me ikkje hackast.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["mottaker"])) {
			$forslag_skjemaErr['mottaker'] = "Mottaker er obligatorisk";
		} else {
			$forslag_mottaker = test_input($_POST["mottaker"]);
			// Sjekke e-postadressa
			if (!filter_var($forslag_mottaker, FILTER_VALIDATE_EMAIL)) {
			$forslag_skjemaErr['mottaker'] = "Feil e-postformat. "; 
		}
		if (empty($_POST["mottaker_namn"])) {
			$forslag_skjemaErr['mottaker_namn'] = "Navn på mottaker-epost er obligatorisk";
		} else {
			$forslag_mottaker_namn = test_input($_POST["mottaker_namn"]);
		}
		if (empty($_POST["tittel"])) {
			$forslag_skjemaErr['tittel'] = "Tittel er obligatorisk";
		} else {
			$forslag_tittel = test_input($_POST["tittel"]);
		}
		if (empty($_POST["kontaktperson"])) {
			$forslag_skjemaErr['kontaktperson'] = "Kontaktperson er obligatorisk";
		} else {
			$forslag_kontaktperson = test_input($_POST["kontaktperson"]);
		}
		if (empty($_POST["baseurl"])) {
			$forslag_skjemaErr['baseurl'] = "Base-URL er obligatorisk";
		} else {
			$forslag_baseurl = test_input($_POST["baseurl"]);
			}
		}
		if (empty($_POST["epost_domene"])) {
			$forslag_skjemaErr['epost_domene'] = "Domene for mottaker-epost er obligatorisk";
		} else {
			$forslag_epost_domene = test_input($_POST["epost_domene"]);
			}
		}
		if (empty($_POST["passord"])) {
			$forslag_skjemaErr['passord'] = "Passordet er obligatorisk";
		} else {
			$forslag_passord = test_input($_POST["passord"]);
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
			include 'lagdb.php';
			if ($forslag_dblaget === 1) {
				$forslag_resultat = 'Alt klart! Ta i bruk skjemaet.';
			}
			elseif ($forslag_dblaget === 0) {
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
?>