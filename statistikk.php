<?php 
include_once('config.php');

// Kople til databasen
$forslag_dbtilkopling = new mysqli($forslag_dbserver, $forslag_dbbrukar, $forslag_dbpassord, $forslag_dbnamn);
// Sjekke tilkopling til databasen
if ($forslag_dbtilkopling->connect_errno) {
    die("Tilkopling feilet: " . $forslag_dbtilkopling->connect_errno . $forslag_dbtilkopling->connect_error);
} 

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
	$forslag_sakene = "";
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
	<script src="standard.js"></script>
	<style>
	</style>
</head>
<body>
	<div id="forslagsboks">
	<h2>Statistikk:</h2><br/>
	<p>
		<em><a href="<?php echo $forslag_baseurl; ?>">Send inn forslag her.</a></em><br/>
		<em><a href="forslag.php">Les innkomne forslag her.</a></em><br/>
	</p>
		<?php
			if (empty($forslag_sakene)) {
				echo "Ingen statistikk";
			}
			else {
				echo "<div class='left'>".$forslag_sakene."</div>";
			}
			// Feilsøke
			// echo "$forslag_resultat $forslag_sakErr $forslag_linjeErr $forslag_namnErr $forslag_epostErr $forslag_typeErr $forslag_passErr $forslag_forslagErr";
		?>
	</div>
</body>
</html>