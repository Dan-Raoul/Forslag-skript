<?php

// Kople til databasen
$forslag_dbtilkopling = new mysqli($forslag_dbserver, $forslag_dbbrukar, $forslag_dbpassord, $forslag_dbnamn);
// Sjekke tilkopling til databasen
if ($forslag_dbtilkopling->connect_errno) {
    die("Tilkopling feilet: " . $forslag_dbtilkopling->connect_errno . $forslag_dbtilkopling->connect_error);
} 

// MySQLi OO lage tabell

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

$forslag_dbtilkopling->close();

?>