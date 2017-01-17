<?php

// PDO lage tabell $forslag_pdo_pdo

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
Registrert DATETIME  NOT NULL
)";

try {
	$forslag_pdo_pdo->exec($forslag_lag_tabell);
	$forslag_dbtilkopling_status = "Tabell opprettet.";
}
catch(PDOException $forslag_pdo_error) {
		$forslag_dbtilkopling_status = "Feil under opprettelsen av tabell: " . $forslag_lag_tabell . "<br/>" . $forslag_pdo_error->getMessage();
}

?>