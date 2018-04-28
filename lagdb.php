<?php

// PDO lage tabell $forslag_pdo_pdo

try {
	$forslag_pdo_pdo		=	new PDO($forslag_pdo_dsn, $forslag_dbbrukar, $forslag_dbpassord, $forslag_pdo_opt);
}
catch (PDOException $forslag_pdo_error) {
	$forslag_dbtilkopling_status = "Feil med kopling til databasen:<br />".$e->getMessage();
	$forslag_dbtilkopling_status_feil = TRUE;
}
catch (Exception $forslag_pdo_error) {
	$forslag_dbtilkopling_status = "Generell feil:<br />".$e->getMessage();
	$forslag_dbtilkopling_status_feil = TRUE;
}

$forslag_lag_tabell = "CREATE TABLE " . $forslag_dbtabell . " (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
Sak VARCHAR(10) NOT NULL,
Delegat INT(10) UNSIGNED NOT NULL,
Namn VARCHAR(50) NOT NULL,
Epost VARCHAR(50) NOT NULL,
Linje VARCHAR(255) NOT NULL,
Type VARCHAR(20) NOT NULL,
Forslag LONGTEXT NOT NULL,
Kommentar LONGTEXT NOT NULL,
IP VARCHAR(20) NOT NULL,
Nettleser VARCHAR(255) NOT NULL,
Referent VARCHAR(255) NOT NULL,
Registrert DATETIME  NOT NULL,
Endret DATETIME,
Endrer VARCHAR(50),
Endrekom LONGTEXT,
EndretIP VARCHAR(20),
Endretnettleser VARCHAR(255),
Endretreferent VARCHAR(255)
)";

try {
	$forslag_pdo_pdo->exec($forslag_lag_tabell);
	$forslag_dbtilkopling_status = "Tabell opprettet. ";
	
}
catch(PDOException $forslag_pdo_error) {
		$forslag_dbtilkopling_status = "Databasefeil under opprettelsen av tabell: " . $forslag_lag_tabell . "<br/>" . $forslag_pdo_error->getMessage();
		$forslag_dbtilkopling_status_feil = TRUE;
}
catch(Exception $forslag_pdo_error) {
		$forslag_dbtilkopling_status = "Generell feil under opprettelsen av tabell: " . $forslag_lag_tabell . "<br/>" . $forslag_pdo_error->getMessage();
		$forslag_dbtilkopling_status_feil = TRUE;
}

if ($forslag_dbtilkopling_status_feil = FALSE) {
	try {
		$forslag_lag_variablar = "INSERT INTO variablar_forslag (Tittel, Opent, Mottakernamn, Mottaker, Kontaktperson, EpostDomene, BaseURL, Passord, SakslisteBrukes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$forslag_pdo_pdo->prepare($forslag_lag_variablar);
		$forslag_pdo_pdo->execute([$forslag_tittel, $forslag_opent, $forslag_mottakernamn, $forslag_mottaker, $forslag_kontaktperson, $forslag_epost_domene, $forslag_baseurl, $forslag_passord, $forslag_saksliste_brukes]);
		$forslag_dbtilkopling_status .= "Variabler lagret";
	}
	catch(PDOException $forslag_pdo_error) {
		$forslag_dbtilkopling_status = "Feil under lagring av variabler: " . $forslag_lag_variablar . "<br/>" . $forslag_pdo_error->getMessage();
		$forslag_dbtilkopling_status_feil = TRUE;
	}
}

?>
