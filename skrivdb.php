<?php

// Kople til databasen
$forslag_dbtilkopling = new mysqli($forslag_dbserver, $forslag_dbbrukar, $forslag_dbpassord, $forslag_dbnamn);
// Sjekke tilkopling til databasen
if ($forslag_dbtilkopling->connect_errno) {
    die("Tilkopling feilet: " . $forslag_dbtilkopling->connect_errno . $forslag_dbtilkopling->connect_error);
} 

// MySQLi OO skriv data
$forslag_skriv_forslag = $forslag_dbtilkopling->prepare("INSERT INTO " . $forslag_dbtabell . " (Sak, Delegat, Namn, Epost, Linje, Type, Forslag, Kommentar, IP, Nettleser, Referent, Registrert) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$forslag_skriv_forslag->bind_param("sissssssssss", $forslag_sak, $forslag_delegat, $forslag_namn, $forslag_epost, $forslag_linje, $forslag_type, $forslag_forslag, $forslag_kommentar, $forslag_ip, $forslag_nettleser, $forslag_referent, $forslag_tid);

if ($forslag_skriv_forslag->execute()) {
	$forslag_dbskrevet = 1;
	$forslag_dbid = mysqli_insert_id($forslag_dbtilkopling);
	$forslag_dbtilkopling_status = "Forslag lagret i databasen. Ditt forslag er digitalt forslag nr. " . $forslag_dbid;
} else {
	$forslag_dbskrevet = 0;
	$forslag_dbid = mysqli_insert_id($forslag_dbtilkopling);
	$forslag_dbtilkopling_status = "Feil ved lagring av forslag i databasen.";
	$forslag_emne = "Feil ved skriving til database: " . $forslag_dbtilkopling->error;
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
						<p>Sendt ' . $forslag_tid . ' fra ' . $forslag_ip . ', med nettleser ' . $forslag_nettleser . ', og ble referert fra ' . $forslag_referent . '</p>
					</body>
					</html>
			';
	$forslag_hoder	=	"From: $forslag_mottaker" . "\r\n" .
				"Reply-To: $forslag_mottaker" . "\r\n" .
				"MIME-Version: 1.0" . "\r\n" .
				"Content-type: text/html; charset=UTF-8" . "\r\n" .
				"X-mailer: PHP/" . phpversion();
	mail($forslag_mottaker, $forslag_emne, $forslag_melding, $forslag_hoder);
}

$forslag_skriv_forslag->close();
$forslag_dbtilkopling->close();
?>