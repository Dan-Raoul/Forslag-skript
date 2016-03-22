<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>
		Oppsett: <?php echo $forslag_tittel; ?>
	</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="standard.css" />
</head>

<body>
	<div id="skjema">
		<h1>Oppsettveiledning av <?php echo $forslag_tittel; ?></h1>
		
		<form action="?oppsett=true" method="post" accept-charset="utf8">
			<label for="opent">Åpne skjema: </label><br/>
			<input type="radio" id="opent" name="opent" value="TRUE" required />Åpent<br/>
			<input type="radio" id="opent" name="opent" value="FALSE" required checked />Stengt<br/>
			<label for="mottaker">E-postadresse til mottaker: </label><br/>
			<input type="text" id="mottaker" name="mottaker" size="25" required /><br/>
			<label for="mottaker_namn">Navn som skal vises på mottaker: </label><br/>
			<input type="text" id="mottaker_namn" name="mottaker_namn" size="25" required /><br/>
			<label for="pass">Passord til skjemaet: </label><br/>
			<input type="password" id="pass" name="pass" size="25" required /><br/>
			<label for="tittel">Tittel på arrangementet (f.eks HEFLM, HULM): </label><br/>
			<input type="text" id="tittel" name="tittel" size="25" required /><br/>
			<label for="kontaktperson">Navn på ansvarlig: </label><br/>
			<input type="text" id="kontaktperson" name="kontaktperson" size="25" required /><br/>
			<label for="baseurl">URL til øverste ledd i skjemaet (f.eks. https://lm.human.no/): </label><br/>
			<input type="text" id="baseurl" name="baseurl" size="25" required /><br/>
			<label for="saksliste_brukes">Skal ferdigutfylt saksliste brukes? (<i>må</i> settes manuelt i variablar.php): </label><br/>
			<input type="radio" id="saksliste_brukes" name="saksliste_brukes" value="TRUE" required checked />Ja<br/>
			<input type="radio" id="saksliste_brukes" name="saksliste_brukes" value="FALSE" required />Nei<br/>
			<label for="dbserver">MySQL-server (mysql.XXXXXX.no): </label><br/>
			<input type="text" id="dbserver" name="dbserver" size="25" required /><br/>
			<label for="dbbrukar">MySQL-brukernavn: </label><br/>
			<input type="text" id="dbbrukar" name="dbbrukar" size="25" required /><br/>
			<label for="dbpassord">MySQL-passord: </label><br/>
			<input type="passord" id="dbpassord" name="dbpassord" size="25" required /><br/>
			<label for="dbnamn">Databasenavn: </label><br/>
			<input type="text" id="dbnamn" name="dbnamn" size="25" required /><br/>
			<label for="dbtabell">Databasetabell (prefiks til tittel på arrangementet): </label><br/>
			<input type="text" id="dbtabell" name="dbtabell" value="forslag_" size="25" required /><br/>
			<input type="submit" class="button" value="Sett opp" /><br/>
			<input type="reset" class="button" value="Tilbakestill" /><br/>
		</form>
</body>
</html>