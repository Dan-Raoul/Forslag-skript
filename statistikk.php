<?php 
include_once('config.php');

// Kople til databasen
$forslag_dbtilkopling = new mysqli($forslag_dbserver, $forslag_dbbrukar, $forslag_dbpassord, $forslag_dbnamn);
// Sjekke tilkopling til databasen
/*if ($dbtilkopling->connect_error) {
    die("Tilkopling feilet: " . $dbtilkopling->connect_error);
} */

// Lese frå database
$forslag_stat_sak ="SELECT id, Sak, COUNT(*) AS freq FROM " . $forslag_dbtabell . " GROUP BY Sak ORDER BY freq DESC";

$forslag_result_sak = $forslag_dbtilkopling->query($forslag_stat_sak);

if($forslag_result_sak->num_rows > 0) {
		$forslag_sakene = "
		<table>
			<tr>
				<th>Sak:</th>
				<th>Antall:</th>
			</tr>
		";
		// output data of each row
		while($forslag_row = mysqli_fetch_assoc($forslag_result_sak)) {
			$forslag_sakene .= "
			<tr>
				<td>".$forslag_row['Sak']."</td>
				<td>".$forslag_row['freq']."</td>
			</tr>
			";
		}
		$forslag_sakene .= "</table>";
}
else {
	$forslag_sakene = "Ingen statistikk.";
}

$forslag_stat_delegat ="SELECT id, Delegat, Namn, COUNT(*) AS freq FROM " . $forslag_dbtabell . " GROUP BY Delegat ORDER BY freq DESC";


$forslag_result_delegat = $forslag_dbtilkopling->query($forslag_stat_delegat);

if($forslag_result_delegat->num_rows > 0) {
		$forslag_delegatene = "
		<table>
			<tr>
				<th>Delegat:</th>
				<th>Navn:</th>
				<th>Antall:</th>
			</tr>
		";
		// output data of each row
		while($forslag_row = mysqli_fetch_assoc($forslag_result_delegat)) {
			$forslag_delegatene .= "
			<tr>
				<td>".$forslag_row['Delegat']."</td>
				<td>".$forslag_row['Namn']."</td>
				<td>".$forslag_row['freq']."</td>
			</tr>
			";
		}
		$forslag_delegatene .= "</table>";
}
else {
	$forslag_delegatene = "Ingen statistikk.";
}


	
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
		<em><a href="<?php echo $forslag_baseurl; ?>">Send inn forslag her.</a><br/></em><br/>
		<em><a href="forslag.php">Les inkomne forslag her.</a><br/></em>
	</p>
		<?php
			echo "<div class='left'>".$forslag_sakene."</div>";
			echo "<div class='right'>".$forslag_delegatene."</div>";
			// Feilsøke
			// echo "$forslag_resultat $forslag_sakErr $forslag_linjeErr $forslag_delegatErr $forslag_namnErr $forslag_epostErr $forslag_typeErr $forslag_passErr $forslag_forslagErr";
		?>
	</div>
</body>
</html>