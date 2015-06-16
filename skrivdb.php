<?php

// Kople til databasen
$dbtilkopling = new mysqli($dbserver, $dbbrukar, $dbpassord, $dbnamn);
// Sjekke tilkopling til databasen
/*if ($dbtilkopling->connect_error) {
    die("Tilkopling feilet: " . $dbtilkopling->connect_error);
} */

// MySQLi OO lage tabell
/*
$lag_tabell = "CREATE TABLE " . $dbtabell . " (
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
if ($dbtilkopling->query($lag_tabell) === TRUE) {
	$dbtilkopling_status = "Tabell opprettet.";
} else {
	$dbtilkopling_status = "Feil under opprettelsen av tabell: " . $dbtilkopling->error;
}
*/

// MySQLi OO skriv data
$skriv_forslag = "INSERT INTO " . $dbtabell . " (Sak, Delegat, Namn, Epost, Linje, Type, Forslag, Kommentar, IP, Nettleser, Referent)
VALUES ('$sak', '$delegat', '$namn', '$epost', '$linje', '$type', '$forslag', '$kommentar', '$ip', '$nettleser', '$referent')";

if ($dbtilkopling->query($skriv_forslag) === TRUE) {
	$dbskrevet = 1;
	$dbid = mysqli_insert_id($dbtilkopling);
	$dbtilkopling_status = "Forslag lagret i databasen. Ditt forslag er digitalt forslag nr. " . $dbid;
} else {
	$dbskrevet = 0;
	$dbid = mysqli_insert_id($dbtilkopling);
	$dbtilkopling_status = "Feil ved lagring av forslag i databasen: " . $skriv_forslag . "<br/>" . $dbtilkopling->error;
	$subject = "Feil ved skriving til database: " . $dbtilkopling->error;
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
	$headers	=	"From: $mottaker" . "\r\n" .
				"Reply-To: $mottaker" . "\r\n" .
				"MIME-Version: 1.0" . "\r\n" .
				"Content-type: text/html; charset=UTF-8" . "\r\n" .
				"X-mailer: PHP/" . phpversion();
	mail($mottaker, $subject, $message, $headers);
}

$dbtilkopling->close();
?>