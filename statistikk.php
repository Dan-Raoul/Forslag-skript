<?php 
include_once('config.php');

// Kople til databasen
$dbtilkopling = new mysqli($dbserver, $dbbrukar, $dbpassord, $dbnamn);
// Sjekke tilkopling til databasen
/*if ($dbtilkopling->connect_error) {
    die("Tilkopling feilet: " . $dbtilkopling->connect_error);
} */

// Lese frå database
$stat_sak ="SELECT id, Sak, COUNT(*) AS freq FROM " . $dbtabell . " GROUP BY Sak ORDER BY freq DESC";

$result_sak = $dbtilkopling->query($stat_sak);

if($result_sak->num_rows > 0) {
		$sakene = "
		<table>
			<tr>
				<th>Sak:</th>
				<th>Antall:</th>
			</tr>
		";
		// output data of each row
		while($row = mysqli_fetch_assoc($result_sak)) {
			$sakene .= "
			<tr>
				<td>".$row['Sak']."</td>
				<td>".$row['freq']."</td>
			</tr>
			";
		}
		$sakene .= "</table>";
}
else {
	$sakene = "Ingen statistikk.";
}

$stat_delegat ="SELECT id, Delegat, Namn, COUNT(*) AS freq FROM " . $dbtabell . " GROUP BY Delegat ORDER BY freq DESC";


$result_delegat = $dbtilkopling->query($stat_delegat);

if($result_delegat->num_rows > 0) {
		$delegatene = "
		<table>
			<tr>
				<th>Delegat:</th>
				<th>Navn:</th>
				<th>Antall:</th>
			</tr>
		";
		// output data of each row
		while($row = mysqli_fetch_assoc($result_delegat)) {
			$delegatene .= "
			<tr>
				<td>".$row['Delegat']."</td>
				<td>".$row['Namn']."</td>
				<td>".$row['freq']."</td>
			</tr>
			";
		}
		$delegatene .= "</table>";
}
else {
	$delegatene = "Ingen statistikk.";
}


	
$dbtilkopling->close();

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>
		Statistikk: Forslag p&aring; <?php echo $tittel; ?>
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
			echo "<div class='left'>".$sakene."</div>";
			echo "<div class='right'>".$delegatene."</div>";
			// Feilsøke
			// echo "$resultat $sakErr $linjeErr $delegatErr $namnErr $epostErr $typeErr $captchaErr $forslagErr";
		?>
	</div>
</body>
</html>