<?php

// Kople til databasen
$forslag_dbtilkopling = new mysqli($forslag_dbserver, $forslag_dbbrukar, $forslag_dbpassord, $forslag_dbnamn);
// Sjekke tilkopling til databasen
/*if ($forslag_dbtilkopling->connect_error) {
    die("Tilkopling feilet: " . $dforslag_btilkopling->connect_error);
} */

// MySQLi OO lage tabell
/*
$forslag_lag_tabell = "CREATE TABLE " . $forslag_dbtabell . " (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
Sak VARCHAR(10) NOT NULL,
Delegat INT(10) UNSIGNED NOT NULL,
Namn VARCHAR(50) NOT NULL,
Epost VARCHAR(50) NOT NULL,
Linje VARCHAR(20) NOT NULL,
Type VARCHAR(20) NOT NULL,
Forslag LONGTEXT NOT NULL,
Kommentar LONGTEXT NOT NULL,
IP VARCHAR(20) NOT NULL,
Nettleser VARCHAR(255) NOT NULL,
Referent VARCHAR(255) NOT NULL,
reg_date TIMESTAMP
)";
if ($forslag_dbtilkopling->query($forslag_lag_tabell) === TRUE) {
	$forslag_dbtilkopling_status = "Tabell opprettet.";
} else {
	$forslag_dbtilkopling_status = "Feil under opprettelsen av tabell: " . $forslag_dbtilkopling->error;
}
*/

// MySQLi OO skriv data
$forslag_skriv_forslag = "INSERT INTO " . $forslag_dbtabell . " (Sak, Delegat, Namn, Epost, Linje, Type, Forslag, Kommentar, IP, Nettleser, Referent)
VALUES ('$forslag_sak', '$forslag_delegat', '$forslag_namn', '$forslag_epost', '$forslag_linje', '$forslag_type', '$forslag_forslag', '$forslag_kommentar', '$forslag_ip', '$forslag_nettleser', '$forslag_referent')";

if ($forslag_dbtilkopling->query($forslag_skriv_forslag) === TRUE) {
	$forslag_dbskrevet = 1;
	$forslag_dbid = mysqli_insert_id($forslag_dbtilkopling);
	$forslag_dbtilkopling_status = "Forslag lagret i databasen. Ditt forslag er digitalt forslag nr. " . $forslag_dbid;
} else {
	$forslag_dbskrevet = 0;
	$forslag_dbid = mysqli_insert_id($forslag_dbtilkopling);
	$forslag_dbtilkopling_status = "Feil ved lagring av forslag i databasen: " . $forslag_skriv_forslag . "<br/>" . $forslag_dbtilkopling->error;
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
						<p>Sendt fra ' . $forslag_ip . ', med nettleser ' . $forslag_nettleser . ', og ble referert fra ' . $forslag_referent . '</p>
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

$forslag_dbtilkopling->close();
?>