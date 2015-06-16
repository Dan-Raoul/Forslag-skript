<?php

// Kople til databasen
$dbtilkopling = new mysqli($dbserver, $dbbrukar, $dbpassord, $dbnamn);
// Sjekke tilkopling til databasen
/*if ($dbtilkopling->connect_error) {
    die("Tilkopling feilet: " . $dbtilkopling->connect_error);
} */

// Lese frå database
$lese_forslag ="SELECT id, Sak, Delegat, Namn, Linje, Type, Forslag, Kommentar FROM " . $dbtabell;

// Søke og kontrollere kva som visast
if (!empty ($dbid)) {
	$bare_fid = $dbid;
	$lese_forslag .= " WHERE id =" . $bare_fid;
}
elseif (!empty ($_GET["registrert"])){
	$bare_fid = test_input ($_GET["registrert"]);
	$lese_forslag .= " WHERE id =" . $bare_fid;
}
elseif (!empty ($_POST['fid'])) {
	$bare_fid = test_input ($_POST['fid']);
	$lese_forslag .= " WHERE id =" . $bare_fid;
}
if (!empty ($_POST['fsak'])) {
	$bare_fsak = test_input($_POST['fsak']);
	$lese_forslag .= " WHERE Sak LIKE '" . $bare_fsak . "%'";
}
if (!empty ($_POST['fdelegat'])) {
	$bare_fdelegat = test_input ($_POST['fdelegat']);
	$lese_forslag .= " WHERE Delegat =" . $bare_fdelegat;
}
if ($_POST['etter'] == 'Sak') {
	$lese_forslag .= " ORDER BY Sak";
	$etter = test_input($_POST['etter']);
}
elseif ($_POST['etter'] == 'Delegat') {
	$lese_forslag .= " ORDER BY Delegat";
	$etter = test_input($_POST['etter']);
}
else {
	$lese_forslag .= " ORDER BY id";
	$etter = test_input($_POST['etter']);
} 
if ($_POST['sortert'] == 'desc') {
	$lese_forslag .= " DESC";
	$sortert = test_input($_POST['sortert']);
}

$result = $dbtilkopling->query($lese_forslag);

if ($result->num_rows > 0) {
    $forslagene = "
		<table>
			<tr>
				<th>Nr:</th>
				<th>Sak:</th>
				<th>Delegat:</th>
				<th>Navn:</th>
				<th>Linje:</th>
				<th>Type:</th>
				<th>Forslag:</th>
				<th>Kommentar:</th>
			</tr>
		";
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $forslagene .= "
		<tr>
			<td>".$row['id']."</td>
			<td>".$row['Sak']."</td>
			<td>".$row['Delegat']."</td>
			<td>".$row['Namn']."</td>
			<td>".$row['Linje']."</td>
			<td>".$row['Type']."</td>
			<td class='brei-f'>".$row['Forslag']."</td>
			<td class='brei-k'>".$row['Kommentar']."</td>
		</tr>
		";
    }
    $forslagene .= "</table>";
} else {
    $forslagene = "Ingen forslag";
}

/* change character set to utf8 */
/*
if (!mysqli_set_charset($dbtilkopling, "utf8")) {
    $forslagene .= "Error loading character set utf8: %s\n" . mysqli_error($dbtilkopling);
} else {
    $forslagene .= "Current character set: %s\n", mysqli_character_set_name($dbtilkopling);
}
*/

// Feilsøking: Vis kva det sorteres etter, og kva spørringa var.
/*
	$variablar = "id=" . $_POST['id'] . ". ";
	$variablar .= "Sak=" . $_POST['Sak'] . ". ";
	$variablar .= "Delegat=" . $_POST['Delegat'] . ". ";
	$variablar .= "etter=" . $_POST['etter'] . ". ";
	$variablar .= "sortert=" . $_POST['sortert'] . ". ";
	$resultat .= "<p>Spørring: " . $lese_forslag . "<br/>Variablar: " . $variablar . "</p>";
*/
	
$dbtilkopling->close();

?>