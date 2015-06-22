<?php 
include_once('config.php');

// Kople til databasen
$forslag_dbtilkopling = new mysqli($forslag_dbserver, $forslag_dbbrukar, $forslag_dbpassord, $forslag_dbnamn);
// Sjekke tilkopling til databasen
/*if ($forslag_dbtilkopling->connect_errno) {
    die("Tilkopling feilet: " . $forslag_dbtilkopling->connect_errno . $forslag_dbtilkopling->connect_error);
} */

// Lese frå database
$forslag_stat_sak ="SELECT id, Sak, COUNT(*) AS freq FROM " . $forslag_dbtabell . " GROUP BY Sak ORDER BY freq DESC";

$forslag_result = $forslag_dbtilkopling->prepare($forslag_stat_sak);

if($forslag_result->execute()) {
	$forslag_result->bind_result($forslag_id, $forslag_sak, $forslag_freq);
	$forslag_result->fetch();
	$forslag_sakene = "
		<table>
			<tr>
				<th>Sak:</th>
				<th>Antall:</th>
			</tr>
		";
		// output data of each row
		while($forslag_row = $forslag_result->fetch()) {
			$forslag_sakene .= "
			<tr>
				<td>".$forslag_sak."</td>
				<td>".$forslag_freq."</td>
			</tr>
			";
		}
		$forslag_sakene .= "</table>";
}
else {
	$forslag_sakene = "Ingen statistikk.";
}

$forslag_stat_delegat ="SELECT id, Delegat, Namn, COUNT(*) AS freq FROM " . $forslag_dbtabell . " GROUP BY Delegat ORDER BY freq DESC";


$forslag_result = $forslag_dbtilkopling->prepare($forslag_stat_delegat);

if($forslag_result->execute()) {
	$forslag_result->bind_result($forslag_id, $forslag_delegat, $forslag_namn, $forslag_freq);
	$forslag_result->fetch();
		$forslag_delegatene = "
		<table>
			<tr>
				<th>Delegat:</th>
				<th>Navn:</th>
				<th>Antall:</th>
			</tr>
		";
		// output data of each row
		while($forslag_row = $forslag_result->fetch()) {
			$forslag_delegatene .= "
			<tr>
				<td>".$forslag_delegat."</td>
				<td>".$forslag_namn."</td>
				<td>".$forslag_freq."</td>
			</tr>
			";
		}
		$forslag_delegatene .= "</table>";
}
else {
	$forslag_delegatene = "Ingen statistikk.";
}


$forslag_result->close();
$forslag_dbtilkopling->close();

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>
		Statistikk: Forslag p&aring; <?php echo $forslag_tittel; ?>
	</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="standard.css" />
	<style>
	</style>
</head>
<body>
	<div id="forslagsboks">
	<h2>Statistikk:</h2><br/>
	<p>
		<em><a href="/">Send inn forslag her.</a><br/></em><br/>
		<em><a href="forslag.php">Les inkomne forslag her.</a><br/></em>
	</p>
		<?php
			echo "<div class='left'>".$forslag_sakene."</div>";
			echo "<div class='right'>".$forslag_delegatene."</div>";
			// Feilsøke
			// echo "$forslag_resultat $forslag_sakErr $forslag_linjeErr $forslag_delegatErr $forslag_namnErr $forslag_epostErr $forslag_typeErr $forslag_captchaErr $forslag_forslagErr";
		?>
	</div>
</body>
</html>